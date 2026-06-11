@extends('layouts.admin')
@section('title','Website Settings')
@section('page-title','Website Settings')
@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="rounded-xl border border-[#E8DCCB] bg-white p-6 shadow-sm">@csrf @method('PUT')<div class="grid gap-5 md:grid-cols-2">
        @foreach(['company_name'=>'Company Name','tagline'=>'Tagline','email'=>'Email','phone'=>'Phone','whatsapp'=>'WhatsApp','business_hours'=>'Business Hours','facebook_url'=>'Facebook URL','instagram_url'=>'Instagram URL','linkedin_url'=>'LinkedIn URL','youtube_url'=>'YouTube URL'] as $key=>$label)
            <div><label class="mb-2 block text-sm font-semibold">{{ $label }}</label><input name="{{ $key }}" value="{{ old($key, setting($key)) }}" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3"></div>
        @endforeach
        <div><label class="mb-2 block text-sm font-semibold">Logo</label><input type="file" name="logo" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">@if(setting('logo'))<img src="{{ asset('storage/'.setting('logo')) }}" class="mt-3 h-20 w-20 rounded-lg object-cover">@endif</div>
        <div><label class="mb-2 block text-sm font-semibold">Favicon</label><input type="file" name="favicon" accept="image/*" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">@if(setting('favicon'))<img src="{{ asset('storage/'.setting('favicon')) }}" class="mt-3 h-12 w-12 rounded-lg object-cover">@endif</div>
        <div class="md:col-span-2"><label class="mb-2 block text-sm font-semibold">Address</label><textarea name="address" rows="3" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">{{ old('address', setting('address')) }}</textarea></div>
        <div class="md:col-span-2"><label class="mb-2 block text-sm font-semibold">Google Map Embed</label><textarea name="google_map_embed" rows="4" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">{{ old('google_map_embed', setting('google_map_embed')) }}</textarea></div>
        <div class="md:col-span-2"><label class="mb-2 block text-sm font-semibold">Footer Text</label><textarea name="footer_text" rows="4" class="w-full rounded-lg border border-[#DCC9AD] px-4 py-3">{{ old('footer_text', setting('footer_text')) }}</textarea></div>
    </div><div class="mt-6"><button class="rounded-lg bg-[#8B5E3C] px-5 py-3 text-sm font-semibold text-white">Save Settings</button></div></form>
    <div class="mt-6 rounded-xl border border-[#E8DCCB] bg-[#FFF8EC] p-5 text-sm text-[#6F665A]"><p class="font-semibold text-[#2B2B2B]">Blade helper examples</p><p class="mt-2"><code>{{ '{{ setting("company_name", "ONYXA Private Limited") }}' }}</code></p><p><code>{{ '{{ setting("phone") }}' }}</code></p></div>
@endsection
