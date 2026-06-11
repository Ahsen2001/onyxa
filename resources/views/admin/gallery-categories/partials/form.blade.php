<div class="grid gap-5">
    <div><label class="mb-2 block text-sm font-semibold">Name</label><input name="name" value="{{ old('name',$category?->name) }}" required class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3"><p class="mt-2 text-xs text-[#6F665A]">Slug is generated automatically.</p></div>
    <div><label class="mb-2 block text-sm font-semibold">Status</label><select name="status" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">@foreach(['active'=>'Active','inactive'=>'Inactive'] as $value=>$label)<option value="{{ $value }}" @selected(old('status',$category?->status ?? 'active')===$value)>{{ $label }}</option>@endforeach</select></div>
    <div class="flex gap-3"><button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Save</button><a href="{{ route('admin.gallery-categories.index') }}" class="rounded-lg border border-[#DCC9AD] px-5 py-3 text-sm font-semibold text-[#8B5E3C]">Cancel</a></div>
</div>
