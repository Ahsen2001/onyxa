<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Media;
use App\Support\HtmlSanitizer;
use App\Support\MediaLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = ProductCategory::active()->ordered()->get();
        $mediaItems = Media::images()->latest()->take(80)->get();
        $allProducts = Product::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.products.create', compact('categories', 'mediaItems', 'allProducts'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $tags = (string) ($data['tags'] ?? '');
        $specificationKeys = $data['specification_keys'] ?? [];
        $specificationValues = $data['specification_values'] ?? [];
        $relatedProductIds = $data['related_product_ids'] ?? [];
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['robots'] = $data['robots'] ?? 'index, follow';
        $data['description'] = HtmlSanitizer::clean($data['description'] ?? null);
        $data['main_image'] = MediaLibrary::imagePathFromRequest($request->input('main_image_media_id')) ?? ($data['main_image'] ?? null);
        $data['og_image'] = MediaLibrary::imagePathFromRequest($request->input('og_image_media_id')) ?? ($data['og_image'] ?? null);
        unset(
            $data['main_image_media_id'],
            $data['additional_media_ids'],
            $data['tags'],
            $data['specification_keys'],
            $data['specification_values'],
            $data['related_product_ids'],
            $data['og_image_media_id']
        );

        if ($request->hasFile('main_image')) {
            $data['main_image'] = MediaLibrary::store($request->file('main_image'), $request->user()->id, $data['name'], 'products')->file_path;
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = MediaLibrary::store($request->file('og_image'), $request->user()->id, $data['name'].' OG image', 'products')->file_path;
        }

        $product = Product::create($data);
        $this->storeAdditionalImages($request, $product);
        $this->syncTags($product, $tags);
        $this->syncSpecifications($product, $specificationKeys, $specificationValues);
        $this->syncRelatedProducts($product, $relatedProductIds);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'tags', 'specifications', 'relatedProducts']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load(['images', 'tags', 'specifications', 'relatedProducts']);
        $categories = ProductCategory::active()->ordered()->get();
        $mediaItems = Media::images()->latest()->take(80)->get();
        $allProducts = Product::query()
            ->whereKeyNot($product->id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.products.edit', compact('product', 'categories', 'mediaItems', 'allProducts'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $tags = (string) ($data['tags'] ?? '');
        $specificationKeys = $data['specification_keys'] ?? [];
        $specificationValues = $data['specification_values'] ?? [];
        $relatedProductIds = $data['related_product_ids'] ?? [];
        $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['robots'] = $data['robots'] ?? 'index, follow';
        $data['description'] = HtmlSanitizer::clean($data['description'] ?? null);
        $selectedMainImage = MediaLibrary::imagePathFromRequest($request->input('main_image_media_id'));
        $selectedOgImage = MediaLibrary::imagePathFromRequest($request->input('og_image_media_id'));
        unset(
            $data['main_image_media_id'],
            $data['additional_media_ids'],
            $data['tags'],
            $data['specification_keys'],
            $data['specification_values'],
            $data['related_product_ids'],
            $data['og_image_media_id']
        );

        if ($selectedMainImage) {
            $this->deleteImage($product->main_image);
            $data['main_image'] = $selectedMainImage;
        }

        if ($request->hasFile('main_image')) {
            $this->deleteImage($product->main_image);
            $data['main_image'] = MediaLibrary::store($request->file('main_image'), $request->user()->id, $data['name'], 'products')->file_path;
        }

        if ($selectedOgImage) {
            $this->deleteImage($product->og_image);
            $data['og_image'] = $selectedOgImage;
        }

        if ($request->hasFile('og_image')) {
            $this->deleteImage($product->og_image);
            $data['og_image'] = MediaLibrary::store($request->file('og_image'), $request->user()->id, $data['name'].' OG image', 'products')->file_path;
        }

        $product->update($data);
        $this->storeAdditionalImages($request, $product);
        $this->syncTags($product, $tags);
        $this->syncSpecifications($product, $specificationKeys, $specificationValues);
        $this->syncRelatedProducts($product, $relatedProductIds);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->load('images');

        $this->deleteImage($product->main_image);
        $this->deleteImage($product->og_image);

        foreach ($product->images as $image) {
            $this->deleteImage($image->image);
        }

        Product::destroy($product->getKey());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function destroyImage(ProductImage $productImage): RedirectResponse
    {
        $this->deleteImage($productImage->image);
        ProductImage::destroy($productImage->getKey());

        return back()->with('success', 'Product image deleted successfully.');
    }

    public function updateStatus(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:published,inactive,draft'],
        ]);

        $product->update(['status' => $data['status']]);

        return back()->with('success', 'Product status updated successfully.');
    }

    private function storeAdditionalImages(Request $request, Product $product): void
    {
        $sortOrder = (int) $product->images()->max('sort_order');

        foreach ((array) $request->input('additional_media_ids', []) as $mediaId) {
            $path = MediaLibrary::imagePathFromRequest($mediaId);

            if (! $path) {
                continue;
            }

            $sortOrder++;

            $product->images()->firstOrCreate(
                ['image' => $path],
                [
                    'alt_text' => $product->name,
                    'sort_order' => $sortOrder,
                ]
            );
        }

        if (! $request->hasFile('additional_images')) {
            return;
        }

        foreach ($request->file('additional_images') as $image) {
            $sortOrder++;
            $media = MediaLibrary::store($image, $request->user()->id, $product->name, 'products');

            $product->images()->create([
                'image' => $media->file_path,
                'alt_text' => $product->name,
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function syncTags(Product $product, string $tags): void
    {
        $tagNames = collect(explode(',', $tags))
            ->map(fn (string $tag): string => trim(strip_tags($tag)))
            ->filter()
            ->unique(fn (string $tag): string => Str::slug($tag))
            ->take(30)
            ->values();

        $product->tags()->delete();

        foreach ($tagNames as $tagName) {
            $product->tags()->create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }
    }

    private function syncSpecifications(Product $product, array $keys, array $values): void
    {
        $product->specifications()->delete();

        foreach ($keys as $index => $key) {
            $key = trim(strip_tags((string) $key));
            $value = trim(strip_tags((string) ($values[$index] ?? '')));

            if ($key === '' || $value === '') {
                continue;
            }

            $product->specifications()->create([
                'spec_key' => $key,
                'spec_value' => $value,
                'sort_order' => $index,
            ]);
        }
    }

    private function syncRelatedProducts(Product $product, array $relatedProductIds): void
    {
        $ids = collect($relatedProductIds)
            ->map(fn ($id): int => (int) $id)
            ->filter(fn (int $id): bool => $id > 0 && $id !== $product->id)
            ->unique()
            ->take(12)
            ->values()
            ->all();

        $product->relatedProducts()->sync($ids);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 2;

        while (Product::query()->where('slug', '=', $slug, 'and')
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function deleteImage(?string $path): void
    {
        MediaLibrary::deleteIfUntracked($path);
    }
}
