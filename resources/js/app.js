import './bootstrap';
import Alpine from 'alpinejs';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

window.Alpine = Alpine;
Alpine.start();

if (!reducedMotion) {
    import('lenis').then(({ default: Lenis }) => {
        const lenis = new Lenis({
            duration: 1.1,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smoothWheel: true,
        });

        const raf = (time) => {
            lenis.raf(time);
            requestAnimationFrame(raf);
        };
        requestAnimationFrame(raf);

        window.__lenis = lenis;
    }).catch(() => {});
}

const initRevealObserver = () => {
    if (reducedMotion || !('IntersectionObserver' in window)) {
        document.querySelectorAll('[data-reveal], [data-reveal-line]')
            .forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const obs = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });

    document.querySelectorAll('[data-reveal], [data-reveal-line]')
        .forEach((el) => obs.observe(el));
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initRevealObserver);
} else {
    initRevealObserver();
}
