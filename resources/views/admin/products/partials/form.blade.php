@php
    $tagValue = old('tags', $product?->tags?->pluck('name')->join(', '));
    $specKeys = old('specification_keys');
    $specValues = old('specification_values');

    if ($specKeys === null) {
        $specifications = $product?->specifications ?? collect();
        $specKeys = $specifications->pluck('spec_key')->all();
        $specValues = $specifications->pluck('spec_value')->all();
    }

    $specRowCount = max(4, count($specKeys) + 1);
    $selectedRelated = collect(old('related_product_ids', $product?->relatedProducts?->pluck('id')->all() ?? []))
        ->map(fn ($id) => (int) $id)
        ->all();
    $selectedCategoryId = (int) old('product_category_id', $product?->product_category_id);
    $currentProductName = old('name', $product?->name);
    $categoryProductNames = $categories->mapWithKeys(fn ($category) => [
        $category->id => array_values($category->product_names ?? []),
    ]);
    $selectedCategoryNames = collect($categoryProductNames[$selectedCategoryId] ?? []);

    if ($currentProductName && ! $selectedCategoryNames->contains($currentProductName)) {
        $selectedCategoryNames = $selectedCategoryNames->prepend($currentProductName);
    }
@endphp

<div class="grid gap-6">
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Product Category</label>
            <select name="product_category_id" required data-product-category-select class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('product_category_id', $product?->product_category_id) === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Product Name</label>
            <select name="name" required data-product-name-select data-current-product-name="{{ $currentProductName }}" data-product-name-options='@json($categoryProductNames)' class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                <option value="">Select product category first</option>
                @foreach ($selectedCategoryNames as $productName)
                    <option value="{{ $productName }}" @selected($currentProductName === $productName)>{{ $productName }}</option>
                @endforeach
            </select>
            <p class="mt-2 text-xs text-[#6F665A]">Select a Product Category first. The Product Name list is managed from Product Categories.</p>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Short Description</label>
        <textarea name="short_description" rows="3" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('short_description', $product?->short_description) }}</textarea>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Description</label>
        <textarea name="description" rows="7" data-ckeditor data-upload-url="{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('description', $product?->description) }}</textarea>
    </div>

    <div class="grid gap-5 lg:grid-cols-3">
        <div>
            <label class="mb-2 block text-sm font-semibold">Material</label>
            <input type="text" name="material" value="{{ old('material', $product?->material) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Size</label>
            <input type="text" name="size" value="{{ old('size', $product?->size) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Price</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product?->price) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Product Tags</label>
        <input type="text" name="tags" value="{{ $tagValue }}" placeholder="eco friendly, coconut shell, handmade" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        <p class="mt-2 text-xs text-[#6F665A]">Separate tags with commas.</p>
    </div>

    <div class="rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-5">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold">Product Specifications</h3>
                <p class="mt-1 text-sm text-[#6F665A]">Add details such as finish, weight, care instructions, dimensions, or origin.</p>
            </div>
        </div>
        <div class="grid gap-3">
            @for ($index = 0; $index < $specRowCount; $index++)
                <div class="grid gap-3 md:grid-cols-[1fr_1.5fr]">
                    <input type="text" name="specification_keys[]" value="{{ $specKeys[$index] ?? '' }}" placeholder="Specification name" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm focus:border-[#8B5E3C] focus:outline-none">
                    <input type="text" name="specification_values[]" value="{{ $specValues[$index] ?? '' }}" placeholder="Specification value" class="rounded-lg border border-[#DCC9AD] px-4 py-3 text-sm focus:border-[#8B5E3C] focus:outline-none">
                </div>
            @endfor
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-3">
        <div>
            <label class="mb-2 block text-sm font-semibold">Availability</label>
            <select name="availability" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                @foreach (['available' => 'Available', 'out_of_stock' => 'Out of stock', 'made_to_order' => 'Made to order'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('availability', $product?->availability ?? 'available') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Status</label>
            <select name="status" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                @foreach (['draft' => 'Draft', 'published' => 'Published', 'inactive' => 'Inactive'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $product?->status ?? 'draft') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center rounded-lg border border-[#DCC9AD] px-4 py-3">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $product?->is_featured)) class="h-4 w-4 rounded border-[#DCC9AD] text-[#8B5E3C]">
            <label for="is_featured" class="ml-3 text-sm font-semibold">Featured product</label>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Main Image</label>
            <x-ui.media-picker name="main_image_media_id" label="Select Main Image from Media Library" :current-path="$product?->main_image" :media-items="$mediaItems ?? collect()" />
            <input type="file" name="main_image" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
            <p class="mt-2 text-xs text-[#6F665A]">Uploading a new file will add it to the Media Library and use it as the main image.</p>
            @if ($product?->main_image)
                <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="mt-3 h-32 w-32 rounded-lg object-cover">
            @endif
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Additional Images</label>
            <input type="file" name="additional_images[]" accept="image/*" multiple class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
            <p class="mt-2 text-xs text-[#6F665A]">Uploaded files are stored in the Media Library.</p>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Add Existing Media as Additional Images</label>
        <div class="grid max-h-72 gap-3 overflow-y-auto rounded-lg border border-[#DCC9AD] p-3 sm:grid-cols-2 lg:grid-cols-4">
            @forelse (($mediaItems ?? collect()) as $media)
                <label class="cursor-pointer rounded-lg border border-[#E8DCCB] p-2 hover:border-[#8B5E3C]">
                    <img src="{{ $media->url() }}" alt="{{ $media->alt_text ?: $media->file_name }}" class="aspect-square w-full rounded-md object-cover">
                    <span class="mt-2 flex items-center gap-2 text-xs font-semibold">
                        <input type="checkbox" name="additional_media_ids[]" value="{{ $media->id }}" class="rounded border-[#DCC9AD] text-[#8B5E3C]">
                        <span class="line-clamp-1">{{ $media->file_name }}</span>
                    </span>
                </label>
            @empty
                <p class="text-sm text-[#6F665A]">No media images uploaded yet.</p>
            @endforelse
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Related Products</label>
        <select name="related_product_ids[]" multiple class="min-h-40 w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
            @forelse (($allProducts ?? collect()) as $relatedProduct)
                <option value="{{ $relatedProduct->id }}" @selected(in_array($relatedProduct->id, $selectedRelated, true))>{{ $relatedProduct->name }}</option>
            @empty
                <option disabled>No other products available</option>
            @endforelse
        </select>
        <p class="mt-2 text-xs text-[#6F665A]">Hold Ctrl on Windows to select multiple related products.</p>
    </div>

    <div class="rounded-xl border border-[#E8DCCB] bg-white p-5">
        <h3 class="text-lg font-semibold">SEO Fields</h3>
        <div class="mt-4 grid gap-5">
            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $product?->meta_title) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $product?->meta_keywords) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">Meta Description</label>
                <textarea name="meta_description" rows="3" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('meta_description', $product?->meta_description) }}</textarea>
            </div>

            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold">OG Title</label>
                    <input type="text" name="og_title" value="{{ old('og_title', $product?->og_title) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold">Canonical URL</label>
                    <input type="url" name="canonical_url" value="{{ old('canonical_url', $product?->canonical_url) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">OG Description</label>
                <textarea name="og_description" rows="3" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('og_description', $product?->og_description) }}</textarea>
            </div>

            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold">OG Image</label>
                    <x-ui.media-picker name="og_image_media_id" label="Select OG Image from Media Library" :current-path="$product?->og_image" :media-items="$mediaItems ?? collect()" />
                    <input type="file" name="og_image" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
                    @if ($product?->og_image)
                        <img src="{{ asset('storage/'.$product->og_image) }}" alt="{{ $product->name }} OG image" class="mt-3 h-24 w-36 rounded-lg object-cover">
                    @endif
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold">Robots Meta</label>
                    <select name="robots" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                        @foreach (['index, follow', 'index, nofollow', 'noindex, follow', 'noindex, nofollow'] as $robots)
                            <option value="{{ $robots }}" @selected(old('robots', $product?->robots ?? 'index, follow') === $robots)>{{ $robots }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white hover:bg-[#724A2E]">Save Product</button>
        <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC]">Cancel</a>
    </div>
</div>
