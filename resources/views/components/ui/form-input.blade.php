@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
])

<div>
    <label for="{{ $name }}" class="text-sm font-semibold text-brand-dark">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" {{ $attributes->merge(['class' => 'mt-2 w-full rounded-lg border border-[#DCC9AD] bg-white px-4 py-3 text-sm outline-none transition focus:border-brand-brown focus:ring-2 focus:ring-brand-brown/15']) }}>
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
