@props([
    'active' => false,
])

<span {{ $attributes->merge(['class' => 'number-mark' . ($active ? ' number-mark--active' : '')]) }}>
    {{ $slot }}
</span>
