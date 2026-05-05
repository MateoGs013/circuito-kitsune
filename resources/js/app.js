import './bootstrap';
import Alpine from 'alpinejs';
import Lenis from 'lenis';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

window.Alpine = Alpine;
Alpine.start();

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const supportsHover = window.matchMedia('(hover: hover)').matches;

// ──────────────────────────────────────────────────────────────────────
// LENIS · smooth scroll (§2.4) — desactivado bajo reduced-motion
// ──────────────────────────────────────────────────────────────────────
if (!reducedMotion) {
    const lenis = new Lenis({
        duration: 1.1,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
    });

    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);

    window.lenis = lenis;
}

// ──────────────────────────────────────────────────────────────────────
// CURSOR CUSTOM (§2.5)
// ──────────────────────────────────────────────────────────────────────
if (supportsHover && !reducedMotion) {
    const dot = document.createElement('div');
    dot.className = 'ck-cursor-dot';
    dot.setAttribute('aria-hidden', 'true');

    const ring = document.createElement('div');
    ring.className = 'ck-cursor-ring';
    ring.setAttribute('aria-hidden', 'true');

    document.body.appendChild(ring);
    document.body.appendChild(dot);

    let pX = window.innerWidth / 2;
    let pY = window.innerHeight / 2;
    let dX = pX, dY = pY, rX = pX, rY = pY;

    window.addEventListener('pointermove', (e) => {
        pX = e.clientX;
        pY = e.clientY;
    });

    const tick = () => {
        dX += (pX - dX) * 0.32;
        dY += (pY - dY) * 0.32;
        dot.style.transform = `translate(${dX}px, ${dY}px) translate(-50%, -50%)`;

        rX += (pX - rX) * 0.12;
        rY += (pY - rY) * 0.12;
        ring.style.transform = `translate(${rX}px, ${rY}px) translate(-50%, -50%)`;

        requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);

    const hoverable = 'a, button, [data-cursor="big"]';
    document.addEventListener('mouseover', (e) => {
        if (e.target.closest(hoverable)) {
            dot.classList.add('ck-cursor-dot--big');
            ring.classList.add('ck-cursor-ring--big');
        }
    });
    document.addEventListener('mouseout', (e) => {
        if (e.target.closest(hoverable)) {
            dot.classList.remove('ck-cursor-dot--big');
            ring.classList.remove('ck-cursor-ring--big');
        }
    });
}

// ──────────────────────────────────────────────────────────────────────
// REVEAL · IntersectionObserver para [data-reveal] y [data-reveal-line]
// ──────────────────────────────────────────────────────────────────────
const initReveal = () => {
    if (reducedMotion || !('IntersectionObserver' in window)) {
        document.querySelectorAll('[data-reveal], [data-reveal-line]')
            .forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -8% 0px' }
    );

    document.querySelectorAll('[data-reveal], [data-reveal-line]')
        .forEach((el) => observer.observe(el));
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReveal);
} else {
    initReveal();
}

// ──────────────────────────────────────────────────────────────────────
// BOOT LOADER · micro-overture <1s primera visita (sessionStorage flag)
// ──────────────────────────────────────────────────────────────────────
const initBootLoader = () => {
    const el = document.querySelector('[data-boot-loader]');
    if (!el) return;

    const shouldSkip = reducedMotion || sessionStorage.getItem('ck-booted') === '1';
    if (shouldSkip) {
        el.classList.add('is-done');
        return;
    }

    const percentEl = el.querySelector('[data-boot-percent]');
    const fillEl = el.querySelector('[data-boot-fill]');

    const start = performance.now();
    const duration = 850;

    const tick = (now) => {
        const t = Math.min(1, (now - start) / duration);
        // ease-out cubic
        const eased = 1 - Math.pow(1 - t, 3);
        const pct = Math.floor(eased * 100);
        if (percentEl) percentEl.textContent = String(pct).padStart(2, '0');
        if (fillEl) fillEl.style.transform = `scaleX(${eased})`;

        if (t < 1) {
            requestAnimationFrame(tick);
        } else {
            setTimeout(() => {
                el.classList.add('is-done');
                sessionStorage.setItem('ck-booted', '1');
            }, 120);
        }
    };
    requestAnimationFrame(tick);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBootLoader);
} else {
    initBootLoader();
}

// ──────────────────────────────────────────────────────────────────────
// GLITCH SCRAMBLE · efecto puntual en hover de [data-glitch]
// ──────────────────────────────────────────────────────────────────────
const initGlitch = () => {
    if (reducedMotion) return;

    const chars = '!<>?#%&+=*0123456789';

    const scramble = (el, target, duration = 360) => {
        if (el.dataset.glitchRunning === '1') return;
        el.dataset.glitchRunning = '1';
        const start = performance.now();
        const len = target.length;

        const tick = (now) => {
            const t = Math.min(1, (now - start) / duration);
            const stable = Math.floor(t * len);
            let out = target.substring(0, stable);
            for (let i = stable; i < len; i++) {
                const c = target[i];
                if (c === ' ' || c === '\n') {
                    out += c;
                } else {
                    out += chars[Math.floor(Math.random() * chars.length)];
                }
            }
            el.textContent = out;
            if (t < 1) {
                requestAnimationFrame(tick);
            } else {
                el.textContent = target;
                el.dataset.glitchRunning = '0';
            }
        };
        requestAnimationFrame(tick);
    };

    document.querySelectorAll('[data-glitch]').forEach((el) => {
        const target = el.textContent;
        el.dataset.glitchTarget = target;
        el.addEventListener('mouseenter', () => scramble(el, target, 320));
    });

    // glitch-flash one-shot al revelarse en viewport
    if ('IntersectionObserver' in window) {
        const flashObs = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.classList.add('is-glitching');
                        setTimeout(() => el.classList.remove('is-glitching'), 420);
                        flashObs.unobserve(el);
                    }
                });
            },
            { threshold: 0.5 }
        );
        document.querySelectorAll('[data-glitch-flash]').forEach((el) => flashObs.observe(el));
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGlitch);
} else {
    initGlitch();
}
