@props([
    'label' => '',
])

<span {{ $attributes->merge(['class' => 'system-tag']) }}>
    <span class="system-tag__bullet" aria-hidden="true"></span>
    <span>{{ $label ?: $slot }}</span>
</span>
