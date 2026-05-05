@props([
    'label' => '',
    'value' => 0,
    'suffix' => '/99',
    'variant' => null, // null | 'ember' | 'ink'
    'pad' => 2,
])

@php
    $classes = 'stat-block';
    if ($variant === 'ember') $classes .= ' stat-block--ember';
    if ($variant === 'ink') $classes .= ' stat-block--ink';
    $padded = str_pad((string) $value, (int) $pad, '0', STR_PAD_LEFT);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="stat-block__label">{{ $label }}</div>
    <div class="stat-block__value">{{ $padded }}@if($suffix)<span class="stat-block__suffix">{{ $suffix }}</span>@endif</div>
</div>
