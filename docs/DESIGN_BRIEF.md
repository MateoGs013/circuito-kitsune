# Circuito Kitsune — Design Brief (cerrado)

> Investigación + decisiones de diseño cerradas para el rediseño visual.
> **No abre interpretación**: esto es la spec. Si algo no está acá, default a "no hacerlo" o preguntar al usuario antes.

---

## 0. Contexto creativo

**Producto**: tienda ficticia de máscaras japonesas cyberpunk. Cada máscara = identidad nocturna que abre un distrito del mercado.

**Tono**:
- Cinematográfico nocturno (referencias: Blade Runner 2049 night scenes, Ghost in the Shell 1995 city shots, Akira opening sequence — pero **sobrio**, no saturado).
- Editorial revista japonesa (referencias: typography-driven, Ma 間 / negative space generoso).
- Clandestino (referencias: dossier, transmisión interceptada, archivo de operador — pero **legible**, no parecer un juego).

**Lo que NO debe parecer**:
- E-commerce convencional (hero + cards + footer)
- Landing SaaS
- Estética NFT
- Estética gamer
- Cyberpunk saturado tipo Tron / Cyberpunk 2077 marketing
- Glassmorphism genérico
- Anime fan-art

---

## 1. Investigación · referencias canónicas

Estudios y sitios para cargar como referencia visual antes de diseñar:

### Awwwards SOTY 2025 + SOTD recientes
- **Lando Norris (OFF+BRAND, SOTY 2025)** — `https://landonorris.com` y case study en `https://www.itsoffbrand.com/our-work/lando-norris`. **Tomar**: choreography de scroll, transitions sharp, bold typography. **Descartar**: WebGL helmet (fuera de scope), color verde lima (no es nuestra paleta).
- **Active Theory v6** — `https://activetheory.net`. **Tomar**: pitch-black bg `#0B0B0B` con UN solo color de acento (`#A970FF` violeta) usado solo en CTAs y progress beads. Pillbox nav reactivo al scroll. Decision: **un solo acento de color, no cuatro**.
- **Messenger (SOTY 2025)** — WebGL planet. **Descartar**: WebGL fuera de scope.

### Estudios japoneses contemporáneos
- **Kenta Toshikura** (Garden Eight, Tokyo) — `https://kentatoshikura.com`. **Tomar**: typography como protagonista, interacciones tipográficas sutiles, layouts editoriales asimétricos.
- **Utsubo** — `https://www.utsubo.com`. **Tomar**: Japanese sensibility con producción internacional, performance-first.
- **Laboratories** (Tokyo) — typography japonesa como núcleo, no decoración.

### Storytelling scroll
- **Codrops Nov 2025** — "How to Build Cinematic 3D Scroll Experiences with GSAP" (`https://tympanus.net/codrops/2025/11/19/how-to-build-cinematic-3d-scroll-experiences-with-gsap/`). **Tomar**: técnica de pinning + horizontal scroll + scrub.

### Tendencias 2026 confirmadas
- **Scrollytelling 2.0**: cada gesture = transition, cada reveal = momentum.
- **Bold typography**: oversized + low color = high contrast emocional.
- **Editorial layouts asimétricos**: salir de la grilla 12-col uniforme.
- **Custom cursor**: dot + ring con velocity reactiveness.
- **Cinematic transitions**: fade-out + fade-in entre secciones, no jumps.
- **Pillbox nav**: reactiva a scroll velocity, mostrar/ocultar.

---

## 2. Sistema visual cerrado

### 2.1 Paleta — REGLA: 1 color de acento, no 4

```
--ink-deep:   #050608   /* fondo global, casi negro */
--ink:        #0F1218   /* paneles oscuros */
--ink-soft:   #1A1F2A   /* hover/elevated */
--bone:       #ECE6D6   /* texto principal */
--bone-dim:   #8A8576   /* texto secundario */
--ash:        #4A4439   /* divisores, líneas */

/* ÚNICO color de acento — usar SOLO para foco/CTA/estado activo */
--ember:      #E63946   /* rojo bermellón japonés */
```

**Regla operativa**:
- 95% de la página = `--ink-deep` + `--bone`
- Acentos = `--ember` SOLO en: link active, número de capítulo activo, subrayado de CTA primario, "online" status dot, drop cap inicial de un artículo.
- **No mezclar** vermillion + cyan + magenta + gold como acento simultáneo. Eso fue uno de los errores de la fase visual.

### 2.2 Tipografía

**3 familias, no más**:
1. **Display latín**: `PP Editorial New` (paid) o **fallback gratis** `Cormorant Garamond` (Google Fonts).
2. **CJK / kanji**: `Shippori Mincho B1` (Google Fonts).
3. **Mono / data**: `JetBrains Mono` (Google Fonts).

**No usar**: Inter ni ningún sans. Si hace falta sans, usar el system stack `system-ui`.

**Reglas de uso**:
- **Headings**: serif italic en mayoría (Cormorant Italic) + display regular (peso 500) para énfasis.
- **Cuerpo de artículo**: serif regular (Cormorant 400) tamaño cómodo (1.125rem-1.25rem).
- **Datos / códigos / coordenadas**: mono (JetBrains 400), all-caps, tracking 0.22-0.32em.
- **CJK**: solo cuando aporta significado, **no como decoración mass-decorativa**. Un kanji por sección máximo.
- **Tamaños hero**: 1 sola pantalla con `clamp(4rem, 14vw, 14rem)`. El resto de pantallas debe ser MÁS chico, no igual de grande.
- **No usar 10 estrategias tipográficas distintas** (ese fue otro error). Usar 3 a lo largo del sitio:
  - Strategy A: serif italic + acento ember en una palabra (hero, manifest, closing)
  - Strategy B: número leading + serif title (catalog, archive sections)
  - Strategy C: mono uppercase tracking-wide (data sections, stats)

### 2.3 Layout principle — Ma 間

- **100% del viewport width siempre**, sin contenedores centrados.
- **Padding lateral generoso** en desktop (px-16 lg:px-24).
- **Negative space ÷ 2** entre secciones (no apretado, no holgado).
- **Asimetría editorial controlada**: grid 12-col con 1 elemento sangrando o desplazado. NO fragmentar todo el título en celdas distintas (eso quedó como rompecabezas, no como diseño).
- **Heading max 2 líneas**. Si necesita más líneas, repensar el copy.

### 2.4 Motion

**Stack cerrado**:
- **Lenis** — smooth scroll. Es el que usan Awwwards SOTY.
- **GSAP + ScrollTrigger** — pinning + scrub. Free version (sin SplitText premium, partir manual).
- **No Alpine.js para motion**. Alpine queda solo para state UI simple (hover preview, filter active state).
- **No CSS-only animation-timeline para movimientos críticos** (soporte aún parcial). Sí para fade-in simple sí.

**Reglas**:
- **Easing**: cubic-bezier(0.65, 0, 0.35, 1) para todo lo que no sea spring.
- **Duraciones**: 380ms hovers, 580-800ms reveals, 1200-1800ms scrubs largos.
- **Stagger**: 60ms entre líneas de un párrafo, 90ms entre tarjetas de una grilla.
- **Pinning + horizontal scroll**: 1 sola sección del home (no más). Esa es la "experiencia firma".
- **`prefers-reduced-motion: reduce`** corta TODO. Sin excepciones.

### 2.5 Cursor custom

- **Dot 6px** que sigue al cursor con lerp 0.32 (rápido).
- **Ring 30px** que sigue con lerp 0.12 (cinematográfico).
- En `hover` sobre `a, button`: dot crece a 36px, ring a 64px, fill ember.
- `mix-blend-mode: difference` para que se lea contra cualquier fondo.
- Ocultar en `(hover: none)` y `prefers-reduced-motion`.

### 2.6 Componentes visuales clave

**`<x-mask-portrait>`** — placeholder editorial (reemplaza al actual `mask-placeholder`):
- Si `hasImage()`: img con `object-cover` y `mix-blend-luminosity` para integrarse al tono.
- Si no: SVG con silueta de máscara minimal (3 trazos: contorno, ojos, marca inferior). Sin "REC", sin hash, sin bandas tipo terminal — eso quedó como UI técnico, no como editorial. La placeholder es **un retrato editorial silenciado**, no un dossier.
- Borde: 1px ash, sin corner brackets innecesarios.

**`<x-system-tag>`** — tag pequeño mono (reemplaza chapter-mark, system-label, terminal-line):
- Format: `▸ ARCHIVO · 02` (dot + texto uppercase tracking-wide).
- 1 solo componente, no 4 distintos para "system labels".

**`<x-number-mark>`** — número de capítulo display:
- Para usar como `01` `02` etc al inicio de secciones.
- Italic Cormorant, color ember si es activo, ash si no.

**`<x-cta-link>`** — link estilo CTA (reemplaza ink-button):
- Texto subrayado animado (underline redraw on hover).
- Flecha que se desplaza a la derecha en hover.
- Variants: `primary` (ember), `ghost` (bone-dim).

---

## 3. Estructura de páginas — wireframe textual

### 3.1 Home — UN solo flujo cinematográfico, no actos numerados

```
[hero · 100vh]
  background: ink-deep
  centro asimétrico
  preheading mono: "▸ 35.6762°N · 139.6503°E · turno noche"
  H1 serif italic: "Las identidades [break] solo existen [break] de noche."
  (palabra "solo" puede tener color ember; el resto bone)
  bajada serif regular: "Una tienda clandestina de máscaras..."
  CTA primary: "Entrar al archivo →"
  scroll indicator inferior

[transition · 60vh — quote pausa]
  background: ink-deep
  cita centrada italic: "El circuito te lee. Te asigna un distrito. Te devuelve una señal."
  número decorativo "壱" en esquina

[archive horizontal pinned · pin desktop · scroll vertical mobile]
  GSAP ScrollTrigger pin + horizontal scrub
  6 paneles, cada panel 100vw
  cada panel ocupa SU color dominante como bg (suavizado al 40-50% para respetar la noche)
  layout interno: nombre serif gigante, código mono pequeño, descripción italic, stats minimal (4 valores en línea, no 4 cards)
  "Ver expediente →" como CTA
  progress bar inferior con "01 / 06" mono

[transmisiones · feed editorial]
  background: ink-deep
  3 transmisiones destacadas
  cada una: serif italic numero (壱 弐 参) + título serif regular + excerpt italic + meta mono
  layout: column única centrada, max-w 720px, gap-y generoso
  CTA "Ver archivo completo →"

[closing · 80vh]
  background: ink-deep (NO vermillion full-vh — eso queda violento)
  serif italic gigante centrada: "Elegí una. Antes de que la señal cambie."
  2 CTA: "Abrir archivo" + "Leer transmisiones"
  fade-out a footer

[footer compacto]
  3 columnas: nav / coordenadas / aviso carrito
  copyright + hash decorativo
  altura ≤ 240px (no el footer pesado actual)
```

**No incluir**: rail vertical de capítulos lateral, breaks full-vh con kanji solitario gigante, marquee horizontal entre secciones, scanlines, light leaks, vignette layered, paper-grain heavy. Todo eso se acumuló y dispersó la atención.

**Sí incluir**: 1 sola identidad atmosférica = grain sutil + ink-deep base + 1 acento ember. Eso es. La inmersión viene del **ritmo** del scroll y del **silencio entre secciones**, no de capas de FX.

### 3.2 Catálogo `/productos` — roster + preview

```
[hero corto · 50vh]
  preheading mono: "▸ ARCHIVO · 06 IDENTIDADES"
  H1 serif italic: "Las máscaras del circuito."
  bajada serif regular
  filtros como tabs underline (no pills)

[roster · column única]
  6 entradas, una debajo de otra
  cada entrada: padding generoso, border-bottom 1px ash
  layout interno: índice mono "no.01" + nombre serif italic GRANDE (clamp 2-5vw) + meta mono (código · distrito · rareza · status)
  hover: padding-left desliza 1.5rem + acento ember en el índice
  click: link al detalle

(NO preview lateral sticky — eso le robó la atención al roster. Si querés ver la máscara, click)
```

### 3.3 Detalle `/productos/{slug}` — expediente

```
[hero · 100vh]
  bg = product.dominant_color, **oscurecido al 50% con overlay ink-deep**
  layout 2 columnas:
    izq col-span-7: meta mono arriba ("expediente 0001 · velocidad · disponible") + nombre H1 serif italic clamp(3.5rem,9vw,9rem) + bajada serif regular
    der col-span-4: portrait dentro de figure con border ash 1px, NO overlap forzado, side by side limpio. El interés viene del **bg color** + tipografía, no de overlap acrobático.
  scroll indicator

[atributos · ink-deep]
  preheading: "▸ 01 · ATRIBUTOS"
  H2 serif italic: "Cómo se comporta el circuito."
  4 stats en columna 2x2 grid en mobile, inline 4 columnas en desktop
  cada stat: kanji decorativo + label mono + valor display serif regular (clamp 4rem-7rem)
  NO barras de progreso (eso era de Fase 2)

[protocolo · ink-deep]
  preheading: "▸ 02 · PROTOCOLO"
  drop cap del primer párrafo en serif regular size 6em color ember
  long_description partido en párrafos
  meta mono al pie con coords + última sync

[acción · ink-deep]
  preheading: "▸ 03 · ACCIÓN"
  H2 serif italic medium: "Reservá esta máscara"
  bajada describiendo estado
  CTA primary "Reservar →" (deshabilitado si !isAvailable)
  microcopy: "El carrito se abre en la próxima fase del circuito."
  link "← Volver al archivo"
```

### 3.4 Transmisiones `/transmisiones`

```
[hero corto · 50vh]
  preheading mono: "▸ FEED · 05 SEÑALES · EN LÍNEA"
  H1 serif italic: "Transmisiones interceptadas."
  bajada

[lista editorial · column única max-w 760px]
  5 entradas
  cada entrada: tag mono (categoría) + número serif italic (壱 弐 参 肆 伍) + título serif regular grande + excerpt italic + meta mono
  border-bottom ash entre entradas
  hover: acento ember en el número
```

### 3.5 Transmisión show `/transmisiones/{slug}`

```
[hero · 60vh]
  preheading mono: "▸ SEÑAL 001 · GUÍA · 4 MIN"
  H1 serif italic clamp(2.75rem, 7vw, 7rem)
  meta mono: autor + fecha
  pull quote del excerpt como `<blockquote>` con border-left ember

[cuerpo · column max-w 720px]
  drop cap en primer párrafo (ember)
  serif regular size 1.125rem leading-[1.85]
  párrafos partidos por formattedBody()
  ink-divider al final
  meta footer mono
```

---

## 4. Anti-patterns a evitar (lecciones de la fase rota)

1. **No usar 4 paletas mezcladas**. 1 acento, no 4.
2. **No usar 10 estrategias tipográficas distintas**. 3 strategies (italic-acento / number-leading / mono-uppercase) repetidas con coherencia.
3. **No fragmentar headings en grid celdas distintas**. Hace que se lean como rompecabezas. Asimetría sí, fragmentación no.
4. **No apilar atmospheric layers** (vignette + scanlines + grain + light-leak + parallax kanji). Elegir 1 base (grain sutil) y dejar el resto al ritmo y silencio.
5. **No sobre-decorar con kanji**. 1 kanji por sección como acento, no como wallpaper de fondo de cada bloque.
6. **No forzar overlap acrobático título/portrait** si no funciona en TODOS los productos. Si Karasu-07 rompe el overlap, no usar overlap.
7. **No agregar "rail vertical lateral", "boot veil", "status bar inferior", "marquee horizontal", "marquee vertical", "scroll progress lateral"** todo junto. Elegir UNO o NINGUNO. La inmersión NO viene de cantidad de UI overlays; viene de la coherencia tipográfica + el ritmo del scroll.
8. **No mezclar Alpine + GSAP** para la misma animación. Alpine para state UI, GSAP para motion choreography.
9. **No crear 11 componentes Blade**. Crear 5 máximo: layout, mask-portrait, system-tag, number-mark, cta-link. Lo demás vive inline.
10. **No prometer interactividad que no existe**. Si el carrito no funciona, decirlo en el copy ("el carrito se abre en la próxima fase"). Sin botones que parecen funcionales pero no lo son.

---

## 5. Acceptance criteria

Al final del rediseño, verificar **manualmente** mirando capturas:

### Funcionales
- [ ] 5 rutas devuelven 200, 1 ruta inválida → 404
- [ ] Filtros del catálogo funcionan vía query-param (sin JS)
- [ ] `php artisan migrate:fresh --seed` corre limpio
- [ ] `npm run build` corre limpio
- [ ] `npm run dev` corre con HMR
- [ ] Responsive: mobile (375px), tablet (768px), desktop (1440px)

### A11y
- [ ] 1 `<h1>` por página
- [ ] Jerarquía h2 > h3 sin saltos
- [ ] HTML semántico (header / nav / main / section / article / aside / footer)
- [ ] Focus visible en todos los interactivos (outline 2px ember, offset 4px)
- [ ] Contraste texto/fondo ≥ 4.5:1 (WebAIM)
- [ ] `prefers-reduced-motion` corta animaciones críticas
- [ ] `aria-label` en botones/links sin texto claro
- [ ] Skip link al main
- [ ] Lighthouse a11y ≥ 90

### Performance
- [ ] Lighthouse perf mobile ≥ 80
- [ ] LCP < 2.5s
- [ ] CLS < 0.1
- [ ] Imágenes lazy-loaded (cuando existan)
- [ ] CSS bundle < 80KB gzipped
- [ ] JS bundle < 100KB gzipped

### Visual
- [ ] Paleta limitada a 6 tokens (ink-deep, ink, ink-soft, bone, bone-dim, ash) + 1 acento (ember)
- [ ] 3 familias tipográficas, no más
- [ ] Sin contenedores `max-w-*` para fondos (usar `w-screen`); contenedores aplican a contenido legible (max-w-prose / max-w-3xl)
- [ ] Cada página tiene su identidad pero comparte el sistema (no "10 páginas distintas que parecen sitios distintos")
- [ ] Mobile NO es desktop apretado: layout repensado por breakpoint

### Storytelling
- [ ] Home: 1 sola sección con pinning horizontal, no 5 actos numerados con breaks
- [ ] Detalle producto: bg color-driven oscurecido (overlay 50% ink-deep), no full color saturado
- [ ] Transmisiones: feed editorial 1 columna, no magazine asimétrico con tamaños mixtos
- [ ] Cierre del home: serif italic clamp grande sobre ink-deep + 2 CTAs, no full-vh vermillion abrupto

---

## 6. Stack final cerrado

```json
{
  "back": "Laravel 13.7.0 (estable, no tocar)",
  "templating": "Blade",
  "css": "Tailwind v4 (@tailwindcss/vite)",
  "bundler": "Vite 7",
  "smooth-scroll": "Lenis 1.x",
  "motion": "GSAP 3.x + ScrollTrigger (free, partir texto manualmente)",
  "interactivity": "Alpine.js 3 (solo state UI: filter active, hover preview)",
  "fonts": "Cormorant Garamond + Shippori Mincho B1 + JetBrains Mono (Google Fonts)",
  "db": "SQLite (database/database.sqlite)"
}
```

**Instalar al inicio**:
```bash
npm install lenis gsap
# alpinejs ya está instalado
```

---

## 7. Sources

- [Lando Norris case study (OFF+BRAND)](https://www.itsoffbrand.com/our-work/lando-norris) — SOTY 2025
- [Active Theory v6](https://activetheory.net/) — black bg + 1 acento
- [Awwwards Annual Awards 2025](https://www.awwwards.com/annual-awards-2025/)
- [Awwwards Sites of the Year](https://www.awwwards.com/websites/sites_of_the_year/)
- [Codrops — Cinematic 3D Scroll with GSAP (Nov 2025)](https://tympanus.net/codrops/2025/11/19/how-to-build-cinematic-3d-scroll-experiences-with-gsap/)
- [Lenis (darkroom.engineering)](https://github.com/darkroomengineering/lenis)
- [GSAP ScrollTrigger docs](https://gsap.com/docs/v3/Plugins/ScrollTrigger/)
- [Kenta Toshikura portfolio](https://kentatoshikura.com/) — JP typography
- [Utsubo Studio](https://www.utsubo.com/) — JP creative tech
- [Awwwards Editorial Layout collection](https://www.awwwards.com/inspiration/editorial-layout)
- [Awwwards Storytelling collection](https://www.awwwards.com/awwwards/collections/storytelling/)
- [Awwwards Japan websites](https://www.awwwards.com/websites/Japan/)
- [Awwwards Dark Themed Website](https://www.awwwards.com/inspiration/dark-themed-website)
- [Web Design Trends 2026 (reallygooddesigns)](https://reallygooddesigns.com/web-design-trends-2026/)
- [Typography Trends 2026 (designmonks)](https://www.designmonks.co/blog/typography-trends-2026)
