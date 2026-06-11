<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-[#E8DCCB] bg-white shadow-sm']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[#F0E6D8] text-sm">
            {{ $slot }}
        </table>
    </div>
</div>
