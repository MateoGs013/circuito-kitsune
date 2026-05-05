@props(['kanji', 'number' => null, 'label' => null, 'total' => null])

<div {{ $attributes->merge(['class' => 'chapter-mark']) }}>
    <span class="chapter-mark__kanji">{{ $kanji }}</span>
    <div class="flex flex-col gap-1">
        @if ($number !== null)
            <span class="chapter-mark__num">
                {{ str_pad((string) $number, 2, '0', STR_PAD_LEFT) }}@if ($total) <span class="opacity-50">&nbsp;/&nbsp;{{ str_pad((string) $total, 2, '0', STR_PAD_LEFT) }}</span>@endif
            </span>
        @endif
        @if ($label)
            <span class="chapter-mark__label">{{ $label }}</span>
        @endif
    </div>
</div>
