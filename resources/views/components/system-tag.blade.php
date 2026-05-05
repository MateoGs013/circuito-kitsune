@props([
    'label' => '',
    'pulse' => false,
    'variant' => null, // null | 'ink' | 'bone'
])

@php
    $classes = 'system-tag';
    if ($pulse) $classes .= ' system-tag--pulse';
    if ($variant === 'ink') $classes .= ' system-tag--ink';
    if ($variant === 'bone') $classes .= ' system-tag--bone';
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    <span class="system-tag__dot" aria-hidden="true"></span>
    <span class="system-tag__label">{{ $label }}</span>
</span>
