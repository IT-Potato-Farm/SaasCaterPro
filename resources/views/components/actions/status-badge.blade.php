<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bgColor }} {{ $textColor }}">
    {{ is_string($status) ? ucfirst($status) : 'Invalid Status' }}
</span>