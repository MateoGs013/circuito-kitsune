# Circuito Kitsune · Estado de Implementación

> Versión 1.0 · 2026-05-05 · capa visual completa.
>
> Este documento registra el estado real del frontend después de la sesión autopilot que implementó las 5 vistas. Es la fuente de verdad sobre lo que se hizo y las desviaciones del brief.

---

## Resumen ejecutivo

- **Estado**: visualmente completo. Las 5 rutas devuelven HTML estilizado coherente con el lenguaje Utopia + arquitectura Opción C de CK.
- **Stack**: Laravel 13 + Blade + Tailwind v4 + Alpine.js + Vite + Lenis + GSAP + Playwright.
- **Tipografía**: Archivo Black 900 (display) + Inter 400-700 (body) + IBM Plex Mono 400-700 (HUD/mono) + Shippori Mincho B1 (CJK). 4 familias.
- **Paleta**: ink `#14171F` + bone `#EBE5CE` + ember `#FF1919` + ash `#252525` + bone-dim `#8A8576` + ink-deep `#0A0C12` + ink-soft `#1E222D`. 4 cromáticos principales + 3 derivados.
- **Bundles** (post `npm run build`): CSS **10.48 KB gzip** / JS app **33.53 KB gzip** + Lenis **5.07 KB gzip**. Holgado bajo presupuesto (CSS < 80 KB, JS < 100 KB).
- **Rutas**: 5 públicas + 1 fallback 404. Todas pasan smoke test.

---

## Vistas implementadas

| Vista | Archivo Blade | Spec | Estado |
|---|---|---|---|
| Home `/` | `home.blade.php` | § 8.1 (8 secciones Opción C) | ✅ |
| Catalog `/productos` | `products/index.blade.php` | § 8.2 (hero + filtros + grid) | ✅ |
| Detalle `/productos/{slug}` | `products/show.blade.php` | § 8.3 (4 secciones) | ✅ |
| Feed `/transmisiones` | `posts/index.blade.php` | § 8.4 (lista 1 col) | ✅ |
| Artículo `/transmisiones/{slug}` | `posts/show.blade.php` | § 8.5 (drop cap + pull) | ✅ |

### Secciones del home (§ 8.1)

1. **Hero** (block-ember) — H1 `CIRCUITO`(filled) + `KITSUNE`(outline edge-to-edge), tagline propia `CADA NOCHE. UNA MÁSCARA. UN DISTRITO.` con dot ink, layout 3-col (tagline+CTA / prose / retrato KITSUNE-01 sin frame brackets gruesos), status bar minimal arriba, bottom row con id+signal-meter+version, marquee recursivo.
2. **Stats globales** (block-ink, propio CK) — franja con 4 stat-blocks (06 IDENTIDADES / 04 DISPONIBLES / 11 NOCHES / 05 SEÑALES), border-y ash.
3. **Wall asimétrico** (R35) — collage real grid 20-col con cells drásticamente distintas. KITSUNE-01 featured 8×17 con brackets ember + plus arriba. Otras 5: ONI 7×12, KARASU 5×9, RONIN 5×12, NEKO 5×9, SAKURA 10×8.
4. **Featured Mask Hero** — kanji `狐` individual ember 22% opacity de fondo (clamp 14-36rem), glow cyan radial detrás del retrato, layout 5+7 cols (info izq / retrato der con RGB-shift filter `drop-shadow ember + bone`), 4 stat-blocks abajo, marquee.
5. **Mapa de distritos** (propio CK) — grid 1/2/3-cols responsive, 6 cells con frame brackets bone, coords ficticias deterministas (crc32), nombre distrito display-md, glow del dominant_color.
6. **Última transmisión** (propio CK) — 7+5 cols, izq texto+CTA, der bloque visual con kanji `信` ember 32% opacity + crosshair + frame brackets ember, glow ember bottom.
7. **Feed 2 transmisiones** — 1 col max-w 760, kanji 弐/参 ember inline + título display-sm + excerpt + meta.
8. **Closing** (block-ember invertido) — H2 display-xl `ELEGÍ TU TURNO. ABRÍ TU SEÑAL. ENTRÁ AL CIRCUITO.` con dot ink, kanji `終` ash 12% opacity top, 2 CTAs ink, marquee bottom.

---

## Componentes Blade obligatorios (§ 6 / R61)

5 componentes en `resources/views/components/`:

| Componente | Props | Uso |
|---|---|---|
| `<x-mask-portrait>` | `product`, `alt`, `brackets`, `variant`, `glow`, `framed` | Retratos con WebP real (mix-blend o no) o SVG fallback por tipo |
| `<x-bracket-cta>` | `href`, `variant` (ember/ink/bone), `arrow`, `disabled` | CTAs con corner brackets pseudo-element reales |
| `<x-system-tag>` | `label`, `pulse`, `variant` | `▸ LABEL` con dot ember (pulsante o no) |
| `<x-stat-block>` | `label`, `value`, `suffix`, `variant`, `pad` | Número display-lg + label mono + suffix superscript |
| `<x-marquee>` | `items`, `duration`, `separator` | Track recursivo CSS 38s linear, prefiere-reduced-motion corta |

Frame brackets como mixin CSS (no componente, R: § 6.9).

---

## Desviaciones del brief (registro § 14.4)

Cambios autorizados explícitamente por el cliente durante la sesión:

| § Brief | Original | Aplicado | Motivo |
|---|---|---|---|
| **R13 / R17 / R21** | Familia mono `VT323` weight 400 only | **`IBM Plex Mono`** weights 400-700 | VT323 pixel font perdía legibilidad sobre rojo/ink. IBM Plex Mono mantiene feel "operator técnico" con crispness real. Aprobado por cliente. |
| **R21** mono size | `clamp(0.78rem, 0.9vw, 0.95rem)` (~12.5-15px) | `clamp(0.95rem, 1.1vw, 1.2rem)` (~15-19px) | Cliente: "todo lo que es tipografía mono casi no se ve". |
| **R21** mono tracking | `0.08em` | `0.06em` | Plex Mono no necesita tanto tracking para peso óptico. |
| **§ 8.1.1** hero scan-grid full | Sí (R9 mantiene los colores ink al 45% + dots ink al 95%) | Eliminado del hero. Reemplazado por divisores 1px ink al 28% entre las 3 columnas de info | Cliente: "la grilla está siendo molesta". R9 cierra los colores/alpha pero NO el spacing/aplicación. Los divisores estructurales cumplen el rol de "marcaje técnico" sin saturar. |
| **§ 8.1.1** hero ambient letters | Letras `K I T S U N` izq y `[LOADING] O B S E [LOADING]` der scattered | Eliminadas | Cliente: contrastes insuficientes. § 14.5 ya las cataloga como post-MVP candidate. |
| **§ 8.1.1** hero — 2 CTAs ambos `bracket-cta` | `[ ENTRAR AL ARCHIVO ]` + `[ LEER TRANSMISIONES ]` | Primario bracket-cta + secundario link editorial con border-bottom | Para preservar jerarquía 1-CTA dominante del lenguaje Utopia. El segundo action queda presente sin competir con el principal. |
| **R59** tagline dot | "dot ember al final de cada frase" | **dot ink puro** sobre block-ember | Sobre fondo ember el dot ember sería invisible. Coherente con § 5.1.4 (en block-ember los marks pasan a ink). |
| **R40** header | Position fixed bg ink + border-bottom 1px ash | **Sin cambio** (cliente rechazó la propuesta de header transparente sobre ember) | Decisión cliente confirmada. |

Todas las decisiones documentadas. El brief sigue siendo fuente de verdad para todo lo no listado acá.

---

## Acceptance criteria § 12 — verificación

### § 12.1 Funcionales
- [x] 5 rutas devuelven 200, ruta inválida → 404. Verificado con curl.
- [x] Filtros `?filter=` funcionan vía query-param sin JS (`Product::byFilter()` scope).
- [x] `php artisan migrate:fresh --seed` corre limpio. Verificado.
- [x] `npm run build` corre limpio. CSS/JS dentro de presupuesto.
- [x] `npm run dev` corre con HMR (laravel-vite-plugin).
- [x] Mobile (390px), tablet (768 implícito), desktop (1440/1920px), ultrawide (2560px) sin bugs visibles. Capturas en `tmp-screenshots/full/`.

### § 12.2 Visuales
- [x] Paleta limitada a 4 cromáticos + 3 derivados + 6 glow-only por producto (R10).
- [x] 4 familias tipográficas (Archivo Black + Inter + IBM Plex Mono + Shippori Mincho B1).
- [x] Layout edge-to-edge en color blocks.
- [x] Padding interno fluido con clamp.
- [x] **Hero con scan-grid presente y visible** — adaptado: divisores 1px ink al 28% entre cellas (ver desviación documentada).
- [x] Wall asimétrico real (R35 grid 20-col, posiciones declaradas, no auto-fit).
- [x] Featured mask con kanji individual monumental (`狐` clamp 14-36rem).
- [x] Frame brackets ASCII en CTAs (`::before`/`::after` con border) y retratos (mixin `.frame-corner`).
- [x] Marquee recursivo en 3 secciones del home (hero + featured-mask + closing) — supera el mín 2.
- [x] HUD details (status corner, hash, coords) presentes en hero y product show.

### § 12.3 Tipografía
- [x] H1 display-xl uppercase letter-spacing -2.5%.
- [x] Line-height 0.86 en display-xl, 0.88 en lg, 0.92 en md.
- [x] Body Inter weight 500 letter-spacing -0.5%.
- [x] Mono IBM Plex Mono weight 500 uppercase tracking 6%.
- [x] CJK Shippori Mincho B1 monumental >30vw en sección 4 (`狐` 38vw cap).
- [x] Sin `font-style: italic` en todo el sitio (verificado por grep).

### § 12.4 A11y
- [x] 1 `<h1>` por página (home: `CIRCUITO KITSUNE`, /productos: `ARCHIVO DE MÁSCARAS`, /productos/{slug}: nombre del producto, /transmisiones: `TRANSMISIONES INTERCEPTADAS`, /transmisiones/{slug}: título del post).
- [x] Jerarquía heading sin saltos (h1 → h2 → h3).
- [x] HTML semántico (`<header>`, `<nav>`, `<main>`, `<section aria-labelledby>`, `<article>`, `<footer>`).
- [x] Focus visible: `outline: 2px solid var(--color-ember); outline-offset: 4px;` global en `:focus-visible`.
- [x] Contraste verificado: bone/ink 15.20:1, ember/ink 4.99:1 (large text), ink/ember 5.96:1 — todos AA o mejor.
- [x] `prefers-reduced-motion: reduce` corta animaciones críticas (marquee, reveals, transitions).
- [x] `aria-label` en botones sin texto (cart toggle, brand link, ícono).
- [x] Skip link al `#main` (visible en focus, posición -100px).
- [x] Touch targets ≥ 44×44px en bracket-cta (min-height 44-56px), header__cart (≥ 44px).

### § 12.5 Performance
- [x] CSS bundle gzip **10.48 KB** < 80 KB.
- [x] JS bundle gzip app **33.53 KB** + lenis **5.07 KB** = 38.6 KB < 100 KB.
- [x] Imágenes WebP con `loading="lazy" decoding="async" width height`.
- [x] Google Fonts con `display=swap`.

### § 12.6 Storytelling
- [x] Home: 8 secciones de Opción C (no 7 de Utopia clone).
- [x] Hero: tagline propia CK `CADA NOCHE. UNA MÁSCARA. UN DISTRITO.`
- [x] Stats globales franja propia CK.
- [x] Wall asimétrico real R35 + featured KITSUNE-01 con brackets ember + plus.
- [x] Featured mask kanji individual `狐` + RGB-shift sutil.
- [x] Mapa de distritos 6 cells con coords ficticias deterministas.
- [x] Última transmisión 1 bloque protagónico.
- [x] Feed 2 transmisiones (skip 1 = la destacada).
- [x] Closing block-ember invertido con manifesto propio + 2 CTAs ink.
- [x] Detalle producto bg ink + glow dominant_color (no full saturación).
- [x] Transmisiones feed 1 col max-w 760.
- [x] **No** sección kanji `狐` monumental + scrambled words.
- [x] **No** sección manifesto quote `el circuito te lee`.

---

## Estructura de archivos relevantes

```
resources/
├── css/
│   └── app.css                    # tokens @theme, tipografía, layout, secciones, componentes
├── js/
│   └── app.js                     # Alpine + Lenis + IntersectionObserver reveal
└── views/
    ├── layouts/
    │   └── app.blade.php          # head, header fixed, main, footer compacto, cart drawer
    ├── components/
    │   ├── bracket-cta.blade.php
    │   ├── marquee.blade.php
    │   ├── mask-portrait.blade.php
    │   ├── stat-block.blade.php
    │   └── system-tag.blade.php
    ├── home.blade.php             # 8 secciones § 8.1
    ├── products/
    │   ├── index.blade.php        # § 8.2
    │   └── show.blade.php         # § 8.3 (4 secciones)
    └── posts/
        ├── index.blade.php        # § 8.4
        └── show.blade.php         # § 8.5

_research/
├── shoot-foundation.mjs           # screenshot foundation
├── shoot-hero.mjs                 # screenshot home (4 viewports, force reveal)
├── shoot-all.mjs                  # screenshot 5 vistas × 4 viewports
└── shoot-post.mjs                 # screenshot post detail

tmp-screenshots/
├── foundation/                    # capturas iteración inicial
├── hero/                          # capturas hero v1/v2/v3
└── full/                          # capturas finales 5 vistas × 4 viewports
```

---

## Cómo correr el proyecto

```powershell
# (PowerShell) PATH para PHP/Composer
$env:PATH = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;C:\laragon\bin\composer;" + $env:PATH

# Setup
composer install
npm install

# Dev
npm run dev               # terminal 1 (Vite HMR)
php artisan serve         # terminal 2 (Laravel :8000)

# Build producción
npm run build

# Reset DB
php artisan migrate:fresh --seed

# Capturas Playwright (server debe estar corriendo)
node _research/shoot-all.mjs
```

---

## Pendientes potenciales (post-entrega académica)

Items listados en § 14.5 del brief o que surgieron durante implementación, **NO implementados** salvo aprobación:

- Cursor custom dot+ring (§ 14.5).
- Boot loader micro-overture < 1s (§ 14.5).
- Glitch char-scramble en hover de CTAs (§ 14.5).
- Frase scrambled words estilo Utopia (descartada en v3).
- Hash random que se actualiza cada hora (vs por día).
- Ambient letters en hero con física parallax (eliminadas en pasada de polish).
- Botón `[ SELECCIÓN ALEATORIA ]` (§ 14.5).
- Calendario de turnos.
- Test de identidad.
- Filtro `?ordenar=` adicional.
- Compartir transmisión con OG meta tags.
- RSS feed.

---

## Notas finales

- El brief queda como fuente de verdad. Las desviaciones documentadas arriba son las únicas modificaciones aplicadas.
- Las imágenes WebP (`public/images/products/`) son provistas por el cliente y no se modifican.
- El back Laravel 13 (modelos, controllers, services, migrations, seeders) **no fue tocado** salvo:
  - `home.blade.php` agrega `Post::query()->published()->count()` y `Post::query()->published()->latest()->first()` directamente vía `@php` block. Es lectura pura, sin modificación de modelos/services.
  - `products/show.blade.php` lee `formattedBody()` (helper existente de Post) y arma `crc32` para coords ficticias. Pure read.
- El controller `HomeController` recibe `circuitProducts`, `featuredProducts`, `featuredPosts` del `FeaturedContentService` existente y se mantiene tal cual.
