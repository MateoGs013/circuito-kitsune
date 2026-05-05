{{-- Carrito visual contemplativo (§ HANDOFF: contemplado visualmente, no funcional) --}}

<div x-cloak x-show="cartOpen" class="cart-overlay" @click="cartOpen = false"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     aria-hidden="true">
</div>

<aside x-cloak x-show="cartOpen"
       x-transition:enter="transition ease-out duration-500"
       x-transition:enter-start="translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-300"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="translate-x-full"
       class="cart-drawer"
       role="dialog"
       aria-modal="true"
       aria-labelledby="cart-title"
       @keydown.escape.window="cartOpen = false">

    <header class="flex items-baseline justify-between mb-12">
        <div>
            <x-system-tag class="mb-3">CARRITO · 00 EXPEDIENTES</x-system-tag>
            <h2 id="cart-title" class="font-display italic font-medium text-bone" style="font-size: clamp(2rem, 4vw, 3rem); line-height: 0.95;">
                Tu archivo<br>está vacío.
            </h2>
        </div>
        <button @click="cartOpen = false"
                class="font-mono uppercase tracking-[0.22em] text-xs text-bone-dim hover:text-ember transition-colors"
                aria-label="Cerrar carrito">
            cerrar ✕
        </button>
    </header>

    <div class="flex-1 flex flex-col justify-between gap-12">
        <div>
            <p class="font-display italic text-bone leading-relaxed mb-8" style="font-size: 1.125rem;">
                El carrito se abre en la próxima fase del circuito.<br>
                Por ahora podés explorar las máscaras del archivo y reservar señales.
            </p>

            <div class="border-t border-ash pt-6 space-y-3 font-mono uppercase text-[0.7rem] tracking-[0.22em] text-bone-dim">
                <div class="flex justify-between">
                    <span>estado</span>
                    <span class="text-ember">no funcional</span>
                </div>
                <div class="flex justify-between">
                    <span>protocolo</span>
                    <span>fase ii</span>
                </div>
                <div class="flex justify-between">
                    <span>habilitación</span>
                    <span>pendiente</span>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ route('products.index') }}" @click="cartOpen = false" class="cta-link cta-link--primary">
                <span>Ver el archivo</span>
                <span class="cta-link__arrow" aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</aside>
