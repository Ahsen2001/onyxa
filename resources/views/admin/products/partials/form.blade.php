<div class="grid gap-6">
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Product Category</label>
            <select name="product_category_id" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('product_category_id', $product?->product_category_id) === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Product Name</label>
            <input type="text" name="name" value="{{ old('name', $product?->name) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
            <p class="mt-2 text-xs text-[#6F665A]">Slug is generated automatically from the product name.</p>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Short Description</label>
        <textarea name="short_description" rows="3" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('short_description', $product?->short_description) }}</textarea>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Description</label>
        <textarea name="description" rows="7" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('description', $product?->description) }}</textarea>
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
            <input type="file" name="main_image" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
            @if ($product?->main_image)
                <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" class="mt-3 h-32 w-32 rounded-lg object-cover">
            @endif
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Additional Images</label>
            <input type="file" name="additional_images[]" accept="image/*" multiple class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
            <p class="mt-2 text-xs text-[#6F665A]">Images are stored in storage/app/public/products.</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white hover:bg-[#724A2E]">Save Product</button>
        <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC]">Cancel</a>
    </div>
</div>
