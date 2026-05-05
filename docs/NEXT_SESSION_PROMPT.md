# Prompt para nueva sesión · Circuito Kitsune

> **Cómo usar**: copiá TODO lo que está debajo de `===PROMPT===` y pegalo como primer mensaje en una nueva sesión de Claude Code abierta en `C:\laragon\www\circuito-kitsune`.
>
> Antes de pegar:
> 1. Cerrar la sesión actual.
> 2. Abrir Claude Code en una sesión NUEVA con cwd `C:\laragon\www\circuito-kitsune`.
> 3. PHP/Composer/Node deben estar accesibles (el prompt lo recuerda).

---

## ===PROMPT===

Hola. Vas a hacer la implementación visual final de **Circuito Kitsune**, un proyecto Laravel 13 académico de tienda ficticia de máscaras japonesas cyberpunk. El back está estable e intocable. La capa visual fue reseteada a cero después de 5 iteraciones fallidas. Existe un brief absoluto v3 cerrado de **2346 líneas** que es la única fuente de verdad.

### Antes de escribir UNA sola línea de código, leé en este orden

1. **`docs/DESIGN_BRIEF.md`** completo — 2346 líneas. Es spec absoluta, no orientativa. Tiene 80 reglas numeradas, anti-patterns documentados, y la estructura cerrada de las 5 páginas del sitio.
2. **`docs/NEXT_SESSION_PROMPT.md`** — este archivo (lo estás leyendo ahora).
3. **`tmp-screenshots/ref-utopia-*.png`** y **`_research/ref-*-*.png`** — capturas reales de utopiatokyo.com (referencia estética). Las 10 capturas desktop están en `tmp-screenshots/`, mobile/tablet/laptop están en `_research/`. NO commiteadas (gitignored), conservadas localmente para consulta visual durante implementación.

### Estado actual del proyecto

- **Repo**: `https://github.com/MateoGs013/circuito-kitsune` (privado).
- **Último commit en main**: `9bd3a20` (brief v3 + assets WebP).
- **Back Laravel 13**: estable e intocable. Modelos, controllers, services, migrations, seeders, rutas funcionando.
- **Front (capa visual)**: reseteado a stubs HTML semántico mínimo en `resources/views/**`. Las 5 rutas devuelven 200 sin estilos.
- **`resources/css/app.css`**: solo `@import "tailwindcss";`.
- **`resources/js/app.js`**: solo bootstrap + Alpine.
- **6 imágenes WebP** del cliente en `public/images/products/` (kitsune, oni, karasu, neko, sakura, ronin). `Product::hasImage()` devuelve `true` para las 6. ~810 KB total.
- **Stack instalado**: Tailwind v4 + Alpine.js + Vite + Playwright (chromium).
- **Stack NO instalado** (a agregar): Lenis, GSAP. El brief v3 los pide para motion.

### Lo que NO debés hacer (anti-patterns documentados, ver § 3 del brief)

- ❌ **No asumir aprobación sin confirmación literal del cliente**. "Me gusta más" no es OK terminado, es "vamos en buena dirección, seguí". OK terminado es "dale terminala" / "siguiente página".
- ❌ **No saltar de sección sin screenshot + STOP + confirmación**. Después de cada sección/página, capturás a 4 viewports (1440 / 1920 / 2560 / 390), las leés vos, las mostrás, esperás OK literal antes de pasar a la siguiente.
- ❌ **No traducir literal de Utopia Tokyo**. CK no usa `MARCADO. ASIGNADO. DEVUELTO.` (era v2 sesgado a clone). Usa `CADA NOCHE. UNA MÁSCARA. UN DISTRITO.` (R59).
- ❌ **No clonar la estructura del home de Utopia**. CK tiene 8 secciones propias en orden distinto (§ 8.1 brief). 3 son nuevas que Utopia no tiene (stats globales, mapa de distritos, última transmisión).
- ❌ **No agregar features no pedidos en el brief**. Si una idea aparece a mitad de implementación, la anotás en § 14.5 candidatos post-MVP, NO la implementás.
- ❌ **No improvisar sobre decisiones del brief**. Si encontrás contradicción/ambigüedad, parar y preguntar. Modificar brief antes de re-implementar.
- ❌ **No usar Cormorant Garamond, Bebas Neue, Inter como display, vermillion `#E63946`, cyan como token, italic, gradient en header, mix-blend-difference en header, border-radius en cards, alpha < 1 sobre rojo, max-width en color blocks**.
- ❌ **No header con `linear-gradient` o `backdrop-filter`**. Header tiene bg sólido `var(--color-ink)` + border-bottom 1px ash (R40).
- ❌ **No wall con cells uniformes en filas**. Wall es **collage asimétrico real** con tamaños drásticamente distintos (R35).

### Lo que SÍ debés hacer

1. **Leer el brief completo** (`docs/DESIGN_BRIEF.md`).
2. **Resumir en 5-8 bullets** qué entendiste del brief antes de tocar código.
3. **Esperar mi confirmación literal** ("dale", "OK arrancá", "procedé").
4. **Cuando confirme, en este orden**:
   1. Instalar deps que faltan: `npm install lenis gsap` (Playwright ya está).
   2. Implementar **foundation**: tokens CSS (`@theme`), Google Fonts vía CDN, layout master (`resources/views/layouts/app.blade.php`), 5 componentes Blade obligatorios (mask-portrait, bracket-cta, system-tag, stat-block, marquee).
   3. Implementar el **home** sección por sección según § 8.1 del brief (8 secciones cerradas).
   4. Después de aprobar el home, ir a `/productos`, `/productos/{slug}`, `/transmisiones`, `/transmisiones/{slug}`.
5. **Por cada sección/página**:
   1. Borrar lo viejo antes de escribir lo nuevo.
   2. Implementar.
   3. `npm run build` + `php artisan serve` (background).
   4. Capturar con Playwright a **1440 / 1920 / 2560 / 390** (4 viewports).
   5. Leer las capturas vos antes de mostrarlas (no confiar en lo que escribiste).
   6. Si algo no se ve bien, **arreglarlo antes de mostrarme**.
   7. Mostrarme las capturas + esperar mi OK literal.
   8. Solo entonces pasar a la siguiente sección.

### Reglas de proceso obligatorias (§ 13 del brief)

- **Una página por vez**. No tocar 2 páginas en paralelo.
- **Una sección por vez** dentro de la página.
- **Borrar lo viejo antes de escribir lo nuevo** — no acumular capas CSS.
- Si después de 2 correcciones del mismo punto sigo insatisfecho, **parar y preguntar** qué está pasando.
- **Si el contexto se siente saturado** (después de ~25 turnos), avisame y armamos otro handoff antes de seguir. El brief debe ser autosuficiente para la siguiente sesión.

### Comandos para correr el proyecto

```powershell
# (PowerShell) PATH para PHP/Composer
$env:PATH = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;C:\laragon\bin\composer;" + $env:PATH

# Solo si recién clonaste el repo (no aplica acá, ya está clonado):
# composer install
# npm install

# Cuando arranquemos la implementación:
npm install lenis gsap          # deps de motion según brief v3
php artisan migrate:fresh --seed # opcional, ya está seedeado
npm run dev                       # terminal 1 (Vite HMR)
php artisan serve                 # terminal 2 (Laravel server :8000)
```

### Constraints académicas (NO negociables, § 1.3 brief)

- Laravel 13 ✓ MVC ✓ Blade ✓ Tailwind v4 ✓
- 1 `<h1>` por página
- HTML semántico (header/nav/main/section/article/footer)
- Mobile-first responsive
- `prefers-reduced-motion: reduce` corta animaciones críticas (§ 9 brief)
- Sin imágenes remotas (Google Fonts CDN está OK; assets de marca solo locales)
- Sin lógica en `routes/web.php`
- Carrito visual NO funcional (copy honesta: "el carrito se abre en la próxima fase del circuito")

### Acceptance criteria

Ver § 12 del brief. Cosas críticas:

- [ ] 5 rutas devuelven 200 + ruta inválida 404.
- [ ] `npm run build` + `php artisan migrate:fresh --seed` corren limpio.
- [ ] Mobile (375px), tablet (768px), desktop (1440px), ultrawide (2560px) sin bugs visibles.
- [ ] Lighthouse mobile: perf ≥ 80, a11y ≥ 90.
- [ ] CSS bundle gzip < 80 KB. JS bundle gzip < 100 KB.
- [ ] Paleta limitada a 4 tokens (ink + bone + ember + ash). 4 familias tipográficas (Archivo Black + Inter + VT323 + Shippori Mincho B1). NO más.
- [ ] Home: 8 secciones de Opción C (no 7 de Utopia clone).
- [ ] Wall asimétrico real (R35).
- [ ] Hero con scan-grid presente y visible.
- [ ] Frame brackets ASCII en CTAs y retratos.
- [ ] Marquee recursivo en mín 2 secciones del home.
- [ ] HUD details (status corner, hash, coords) presentes.
- [ ] Sin ningún `font-style: italic`.
- [ ] Focus visible en todos interactivos.
- [ ] `prefers-reduced-motion` testeado.

### Glosario de términos del brief

- **Block** — `<section>` con bg edge-to-edge en uno de 2 modos (ink o ember).
- **Manifesto** — display brutalista uppercase como sección dominante.
- **HUD** — UI técnico (status corner, hash, coords, version, signal meter).
- **Marquee** — línea horizontal recursiva con texto mono.
- **Bracket CTA** — botón con corner brackets ASCII reales.
- **Frame brackets** — marcas de esquina en retratos / cells.
- **Wall** — collage asimétrico de las 6 máscaras (no grid uniforme).
- **Featured** — la máscara protagonista del día con tratamiento ember + kanji individual.
- **Stats globales / Mapa de distritos / Última transmisión** — las 3 secciones propias de CK que NO están en Utopia.

---

Empezá leyendo el brief. Cuando termines de leerlo, resumime en 5-8 bullets qué entendiste y esperá mi confirmación antes de tocar código. Si algo del brief te genera dudas concretas, listálas como preguntas en el resumen.

## ===FIN PROMPT===

---

## Notas para mateo (no parte del prompt)

1. **Lo más importante**: el brief v3 ratifica Opción C — CK como producto propio con lenguaje Utopia. Si en la nueva sesión la IA empieza a clonar Utopia (manifesto quote, kanji monumental, scrambled words, tagline traducida), frenala y citá § 1.4.2 + § 8.1 del brief.

2. **Cadencia esperada**: foundation (tokens + componentes base) → home § 8.1.1 hero → 8.1.2 stats → 8.1.3 wall → 8.1.4 featured → 8.1.5 mapa → 8.1.6 última transmisión → 8.1.7 feed → 8.1.8 closing → footer. Cada paso con screenshots a 4 viewports + tu OK.

3. **Si la IA dice "voy a hacer X" sin haber leído el brief**, frenala. Decile literal: "primero leé `docs/DESIGN_BRIEF.md` completo, después resumí lo que entendiste".

4. **Si la IA empieza a iterar sin parar y sumar features**, decile: "stop. revisemos el brief. ¿qué dice § X?". El brief es la fuente de verdad.

5. **Si la IA no pregunta antes de improvisar**, decile: "el brief no cubre eso. ¿preguntaste o asumiste?". El brief deliberadamente NO cubre todo — algunas decisiones quedan para hablar.

6. **Si la IA dice "lo arreglo todo de una"**, decile: "una sección a la vez. screenshot + check antes de seguir". Ese fue el patrón fallido en sesiones previas.

7. **Si después de 20-25 turnos la cosa se siente saturada**, pedile que escriba un nuevo handoff y arrancá otra sesión. No insistas con la misma sesión.

8. **Para revisión visual**: pedile que tome screenshots con Playwright (ya está instalado, `npx playwright install chromium` ya corrió) y los lea él mismo antes de mostrarte. Que vea lo que hizo, no que confíe en lo que escribió.

9. **Si la implementación falla otra vez**, las 3 cosas a verificar son:
   - ¿La IA leyó el brief antes de tocar código? (sin esto, todo lo nuevo se contamina con suposiciones)
   - ¿Está siguiendo el brief o improvisando? (pedile que cite el § específico al tomar decisiones)
   - ¿Una sección a la vez con check visual? (si está haciendo todo de una sin mostrarte, frenala)
