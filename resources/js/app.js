import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ════════════════════════════════════════════════════════════════════
//  CUSTOM CURSOR · dot + ring
// ════════════════════════════════════════════════════════════════════
const supportsHover = window.matchMedia('(hover: hover)').matches;
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (supportsHover && !reducedMotion) {
    const dot = document.createElement('div');
    dot.className = 'ck-cursor-dot';
    dot.setAttribute('aria-hidden', 'true');

    const ring = document.createElement('div');
    ring.className = 'ck-cursor-ring';
    ring.setAttribute('aria-hidden', 'true');

    document.body.appendChild(ring);
    document.body.appendChild(dot);

    let pointerX = window.innerWidth / 2;
    let pointerY = window.innerHeight / 2;
    let dotX = pointerX;
    let dotY = pointerY;
    let ringX = pointerX;
    let ringY = pointerY;

    window.addEventListener('pointermove', (e) => {
        pointerX = e.clientX;
        pointerY = e.clientY;
    });

    const tick = () => {
        dotX += (pointerX - dotX) * 0.32;
        dotY += (pointerY - dotY) * 0.32;
        dot.style.transform = `translate(${dotX}px, ${dotY}px) translate(-50%, -50%)`;

        ringX += (pointerX - ringX) * 0.12;
        ringY += (pointerY - ringY) * 0.12;
        ring.style.transform = `translate(${ringX}px, ${ringY}px) translate(-50%, -50%)`;

        requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);

    const hoverSelector = 'a, button, [data-cursor="big"], .masthead-line';
    document.addEventListener('mouseover', (e) => {
        if (e.target.closest(hoverSelector)) {
            dot.classList.add('ck-cursor-dot--big');
            ring.classList.add('ck-cursor-ring--big');
        }
    });
    document.addEventListener('mouseout', (e) => {
        if (e.target.closest(hoverSelector)) {
            dot.classList.remove('ck-cursor-dot--big');
            ring.classList.remove('ck-cursor-ring--big');
        }
    });
}

// ════════════════════════════════════════════════════════════════════
//  WORD REVEAL · auto-split text in [data-words] then stagger
// ════════════════════════════════════════════════════════════════════
const splitWords = () => {
    document.querySelectorAll('[data-words]:not([data-words-ready])').forEach((el) => {
        const html = el.innerHTML;
        // Split at whitespace boundaries while preserving inline HTML tags as units
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        const out = [];
        const walk = (node) => {
            if (node.nodeType === Node.TEXT_NODE) {
                const parts = node.textContent.split(/(\s+)/);
                for (const p of parts) {
                    if (p.trim() === '') {
                        out.push(document.createTextNode(p));
                    } else {
                        const span = document.createElement('span');
                        span.className = 'word';
                        span.textContent = p;
                        out.push(span);
                    }
                }
            } else if (node.nodeType === Node.ELEMENT_NODE) {
                // wrap whole inline element as a single word for stagger
                const wrapper = document.createElement('span');
                wrapper.className = 'word';
                wrapper.appendChild(node.cloneNode(true));
                out.push(wrapper);
            }
        };
        Array.from(tmp.childNodes).forEach(walk);
        el.innerHTML = '';
        out.forEach((n) => el.appendChild(n));
        el.classList.add('word-reveal');
        el.setAttribute('data-words-ready', '');
    });
};

// ════════════════════════════════════════════════════════════════════
//  REVEAL ON SCROLL · .reveal y .word-reveal vía IntersectionObserver
// ════════════════════════════════════════════════════════════════════
let revealObserver = null;
if ('IntersectionObserver' in window && !reducedMotion) {
    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );
}

const observeReveals = () => {
    if (!revealObserver) {
        document.querySelectorAll('.reveal, .word-reveal').forEach((el) => el.classList.add('is-visible'));
        return;
    }
    document.querySelectorAll('.reveal:not(.is-visible), .word-reveal:not(.is-visible)').forEach((el) => {
        revealObserver.observe(el);
    });
};

// ════════════════════════════════════════════════════════════════════
//  CHAPTER RAIL · indicador lateral del acto activo (home only)
// ════════════════════════════════════════════════════════════════════
const initChapterRail = () => {
    const rail = document.querySelector('[data-chapter-rail]');
    if (!rail) return;

    const items = Array.from(rail.querySelectorAll('[data-chapter-key]'));
    const sections = Array.from(document.querySelectorAll('[data-chapter]'));
    if (sections.length === 0 || items.length === 0) return;

    const activate = (key) => {
        items.forEach((it) => {
            it.classList.toggle('is-active', it.dataset.chapterKey === key);
        });
    };

    if (!('IntersectionObserver' in window)) return;

    const sectionObserver = new IntersectionObserver(
        (entries) => {
            // pick the entry with largest intersectionRatio currently intersecting
            const intersecting = entries.filter((e) => e.isIntersecting);
            if (intersecting.length === 0) return;
            const top = intersecting.reduce((a, b) =>
                a.intersectionRatio > b.intersectionRatio ? a : b
            );
            const key = top.target.dataset.chapter;
            if (key) activate(key);
        },
        { threshold: [0.25, 0.5, 0.75], rootMargin: '-30% 0px -30% 0px' }
    );

    sections.forEach((s) => sectionObserver.observe(s));
};

// ════════════════════════════════════════════════════════════════════
//  STATUS BAR · clock vivo
// ════════════════════════════════════════════════════════════════════
const tickClock = () => {
    const el = document.querySelector('[data-status-clock]');
    if (!el) return;
    const now = new Date();
    const hh = String(now.getHours()).padStart(2, '0');
    const mm = String(now.getMinutes()).padStart(2, '0');
    const ss = String(now.getSeconds()).padStart(2, '0');
    el.textContent = `${hh}:${mm}:${ss}`;
};

const startClock = () => {
    tickClock();
    setInterval(tickClock, 1000);
};

// ════════════════════════════════════════════════════════════════════
//  BOOT
// ════════════════════════════════════════════════════════════════════
const boot = () => {
    splitWords();
    observeReveals();
    initChapterRail();
    startClock();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
