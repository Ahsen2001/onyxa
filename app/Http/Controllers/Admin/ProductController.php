<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product = Product::create($data);
        $this->storeAdditionalImages($request, $product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load('images');
        $categories = ProductCategory::active()->ordered()->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('main_image')) {
            $this->deleteImage($product->main_image);
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($data);
        $this->storeAdditionalImages($request, $product);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->load('images');

        $this->deleteImage($product->main_image);

        foreach ($product->images as $image) {
            $this->deleteImage($image->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function destroyImage(ProductImage $productImage): RedirectResponse
    {
        $this->deleteImage($productImage->image);
        $productImage->delete();

        return back()->with('success', 'Product image deleted successfully.');
    }

    private function storeAdditionalImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('additional_images')) {
            return;
        }

        $sortOrder = (int) $product->images()->max('sort_order');

        foreach ($request->file('additional_images') as $image) {
            $sortOrder++;

            $product->images()->create([
                'image' => $image->store('products', 'public'),
                'alt_text' => $product->name,
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 2;

        while (Product::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
