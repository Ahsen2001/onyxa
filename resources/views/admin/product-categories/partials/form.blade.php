<div class="grid gap-5">
    <div>
        <label class="mb-2 block text-sm font-semibold">Category Name</label>
        <input type="text" name="name" value="{{ old('name', $category?->name) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
        <p class="mt-2 text-xs text-[#6F665A]">Slug is generated automatically from the category name.</p>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Description</label>
        <textarea name="description" rows="5" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('description', $category?->description) }}</textarea>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">Product Names</label>
        <textarea name="product_names" rows="8" placeholder="Enter one product name per line" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">{{ old('product_names', collect($category?->product_names ?? [])->join("\n")) }}</textarea>
        <p class="mt-2 text-xs text-[#6F665A]">These names will appear in the Product Name dropdown after this category is selected on the Add Product page.</p>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Status</label>
            <select name="status" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3 focus:border-[#8B5E3C] focus:outline-none">
                @foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $category?->status ?? 'active') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($category?->image)
        <div>
            <p class="mb-2 text-sm font-semibold">Current Image</p>
            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="h-32 w-32 rounded-lg object-cover">
        </div>
    @endif

    <div class="flex flex-wrap gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white hover:bg-[#724A2E]">Save Category</button>
        <a href="{{ route('admin.product-categories.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C] hover:bg-[#FFF8EC]">Cancel</a>
    </div>
</div>
