# Circuito Kitsune — Handoff

> Documento de transición entre sesiones de Claude.
> Producido `2026-05-04` después de 5 fases iterativas que terminaron acumulando deuda visual.
> **Próxima sesión empieza con contexto limpio leyendo este doc + `DESIGN_BRIEF.md` + `NEXT_SESSION_PROMPT.md`.**

---

## 1. Estado real del proyecto

### ✅ Estable — NO se debe tocar

Todo el back y la lógica funciona. La consigna académica está cumplida a nivel datos/MVC/migrations/seeders.

| Capa | Estado | Archivos |
|---|---|---|
| Stack | ✅ Laravel 13.7.0 + Blade + Tailwind v4 + Vite + Alpine.js + SQLite | `composer.json`, `package.json`, `vite.config.js` |
| Modelos | ✅ Métodos de dominio robustos (probados ante datos vacíos) | `app/Models/Product.php`, `app/Models/Post.php` |
| Service | ✅ `getFeaturedProducts/Posts/Available/CircuitProducts` | `app/Services/FeaturedContentService.php` |
| Controllers | ✅ Delgados (≤10 líneas) | `app/Http/Controllers/{Home,Product,Post}Controller.php` |
| Migrations | ✅ products (18 campos propios) + posts (10 campos propios) | `database/migrations/2026_05_04_*.php` |
| Seeders | ✅ 6 productos + 5 transmisiones con los nombres exactos pedidos | `database/seeders/{Database,Product,Post}Seeder.php` |
| Rutas | ✅ 5 rutas + filtros query-param | `routes/web.php` |
| Config imágenes | ✅ `public/images/{products,hero,textures}/.gitkeep`, fallback `Product::hasImage()` | |

**Comandos para verificar (todo verde)**:
```powershell
$env:PATH = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;C:\laragon\bin\composer;" + $env:PATH
cd C:\laragon\www\circuito-kitsune
composer install
npm install
php artisan migrate:fresh --seed
php artisan serve
```

### ❌ Inestable — DESCARTAR antes del próximo rediseño

La capa visual actual (vistas Blade + CSS) es producto de iteraciones acumulativas con contexto saturado. El último rediseño ("estilo Awwwards japonés cyberpunk") **NO LLEGÓ**. Específicamente:

- `resources/views/home.blade.php` — 5 actos apilados, breaks 面/声, rail vertical, scroll-snap horizontal. Visualmente roto en partes (overlap forzado, jerarquía tipográfica sin coherencia).
- `resources/views/products/index.blade.php` — masthead-line roster con preview sticky. La idea es buena, la ejecución no llegó.
- `resources/views/products/show.blade.php` — hero color-driven con título absolute sobre portrait. Funciona en 2 productos, rompe en otros (Sakura-404, Karasu-07 quedan extraños).
- `resources/views/posts/index.blade.php`, `posts/show.blade.php` — magazine asimétrico + drop cap. OK pero del mismo idioma visual roto.
- `resources/views/layouts/app.blade.php` — header `mix-blend-difference` + status bar inferior + boot veil. El boot veil queda separado del resto.
- `resources/css/app.css` — 600+ líneas con utilidades heredadas de 4 paletas distintas (sumi → cyberpunk → editorial bone → cyberpunk-noche). Hay clases muertas, hay classes que se pisan, hay tokens duplicados.
- `resources/views/components/*.blade.php` — chapter-mark, ink-button, mask-placeholder. La placeholder con SVG facial está OK pero el resto se acopla a la paleta rota.

**Recomendación: tirar TODA la capa visual y rehacer desde cero** siguiendo el `DESIGN_BRIEF.md` y el `NEXT_SESSION_PROMPT.md`.

### 🟡 Archivos basura para borrar

- `tmp-screenshots/` — capturas de QA de esta sesión
- `screenshot.mjs` — script de Playwright para QA
- `playwright` dev dependency en `package.json` — se puede sacar si no se usa para tests automatizados
- Backup viejo `circuito-kitsune-backup/` — ya no existe pero verificar

---

## 2. Qué SÍ funciona del back y debe respetarse

### Modelo `Product`

```php
fillable: [
    'name', 'slug', 'code', 'category', 'rarity', 'district',
    'price' (integer), 'short_description', 'long_description',
    'dominant_color', 'status' (disponible|próxima|agotada),
    'signal_level', 'agility', 'spirit', 'ferocity' (0-99),
    'image_path', 'is_featured'
]
métodos: isAvailable(), hasImage(), formattedPrice(), rarityLabel(),
         statusLabel(), dominantColorStyle()
scopes: featured(), available(), byFilter($filter)
constantes: STATUS_AVAILABLE, STATUS_UPCOMING, STATUS_SOLD_OUT
route key: slug
```

### Modelo `Post`

```php
fillable: [
    'title', 'slug', 'excerpt', 'body', 'category', 'author',
    'published_at' (datetime), 'reading_time' (int),
    'cover_tone', 'is_featured'
]
métodos: isPublished(), formattedDate(), readingTimeLabel(), formattedBody()
scopes: featured(), published()
route key: slug
```

### Datos sembrados (no inventar nombres nuevos)

**6 máscaras** (orden de seeder, no por id):
1. `Kitsune-01: Zorro de Neón` (KSN-01, cyan, disponible, featured)
2. `Oni-09: Protocolo Rojo` (ONI-09, red, disponible, featured)
3. `Karasu-07: Señal Negra` (KRS-07, violet, disponible, featured)
4. `Neko-03: Glitch de la Suerte` (NKO-03, gold, disponible)
5. `Sakura-404: Flor Rota` (SKR-404, magenta, próxima)
6. `Ronin-X: Último Pasajero` (RNX-00, blue, agotada)

**5 transmisiones**:
1. Cómo elegir tu primera máscara (Guía, featured, cover_tone cyan)
2. Qué significa la rareza dentro del circuito (Sistema, featured, cover_tone violet)
3. Nuevas señales desde el Distrito 09 (Novedades, featured, cover_tone red)
4. Kitsune, Oni y Karasu: tres formas de moverse por la ciudad (Identidades, cover_tone magenta)
5. Protocolo nocturno para nuevos usuarios (Acceso, cover_tone gold)

### Rutas (5 + 1 query-param de filtro)

```
GET /                              → home
GET /productos                     → products.index (acepta ?filter=...)
GET /productos/{product:slug}      → products.show
GET /transmisiones                 → posts.index
GET /transmisiones/{post:slug}     → posts.show
```

Filtros válidos: `disponibles | proximas | agotadas | raras | legendarias`

### Constraints académicas (no negociables)

- Laravel 13 ✓
- MVC respetado ✓
- Blade ✓
- Tailwind CSS ✓ (v4 con `@tailwindcss/vite`, sin `tailwind.config.js`)
- Migrations + Seeders ✓
- `routes/web.php` sin lógica ✓
- Carrito **contemplado visualmente, no funcional** ✓ (mantener este criterio)
- `datos.txt` con plantilla ✓ (placeholders pendientes de completar por el alumno)
- `README.md` con tecnologías + comandos ✓

### Imágenes

`public/images/products/{slug}.webp` — si existen, `hasImage()` las detecta y la vista las muestra en lugar del placeholder. **Sin imágenes externas, sin links remotos**. El placeholder actual es un SVG facial decente.

---

## 3. Qué se aprendió de las 5 fases (lessons learned)

| Intento | Por qué falló |
|---|---|
| Fase 1 — Tailwind básico, cards en grilla | Cumplía consigna pero "completamente básico". |
| Fase 2 — Cyberpunk neón cyan/magenta + paneles técnicos | "Limpio prolijo" en lugar de experimental. Cards apiladas seguían siendo cards. Mapa de identidades resultó ser grilla 3×2, no mapa. |
| Fase 3 — Boot screen + mapa SVG real con conectores | Mejoró pero seguía sintiéndose como "página". |
| Fase 4 — Paleta editorial japonesa (sumi/bone/vermillion) + horizontal scroll-snap | Bueno como concepto, pero "diurno editorial" mal calibrado para "nocturno clandestino". |
| Fase 5 — Cyberpunk-noche + boot veil + status bar + capítulos + breaks 面/声 + outline text + parallax | **Quedó roto**: la fórmula de títulos `[plain] / *italic vermillion* / [plain]` se repitió en 10 secciones, las secciones se sentían apiladas sin ritual real, el overlap del detalle no funcionó en todos los productos. |

### Patrón que se repitió (anti-pattern de proceso)

1. Acumulé clases CSS de cada fase encima de las anteriores sin limpiar.
2. Componentes se agregaron pero los viejos no se borraron del todo.
3. La paleta cambió 4 veces pero `tokens` antiguos quedaron rondando.
4. Cada iteración partió del estado anterior, no de cero.
5. El contexto de la sesión se saturó (50+ turnos) y mis decisiones perdieron coherencia.

**Lección**: para el próximo rediseño, **borrar la capa visual completa y partir de cero**, en una sesión limpia, con el `DESIGN_BRIEF.md` como única fuente de verdad.

---

## 4. Cómo iniciar la próxima sesión

### Opción A (recomendada): sesión limpia con prompt cerrado

1. Abrir nueva sesión de Claude Code en `C:\laragon\www\circuito-kitsune`.
2. Como primer mensaje, copiar/pegar el contenido de `docs/NEXT_SESSION_PROMPT.md`.
3. Antes de ejecutar nada, Claude debe leer `docs/HANDOFF.md` y `docs/DESIGN_BRIEF.md`.
4. Recién entonces se borra la capa visual y se rehace.

### Opción B: continuar en esta sesión

No recomendado. El contexto está saturado. Cada nuevo cambio acumula deuda en lugar de resolverla.

### Antes de empezar el rediseño (checklist de cleanup)

```powershell
cd C:\laragon\www\circuito-kitsune

# 1. snapshot del estado actual por si se necesita rollback
git init
git add .
git commit -m "checkpoint: estado al cierre de fase visual experimental"

# 2. borrar capa visual rota (back queda intacto)
Remove-Item -Recurse -Force resources\views\layouts\app.blade.php
Remove-Item -Recurse -Force resources\views\home.blade.php
Remove-Item -Recurse -Force resources\views\products
Remove-Item -Recurse -Force resources\views\posts
Remove-Item -Recurse -Force resources\views\components
Remove-Item -Force resources\css\app.css

# 3. borrar basura de QA
Remove-Item -Recurse -Force tmp-screenshots
Remove-Item -Force screenshot.mjs
npm uninstall playwright

# 4. recrear estructura mínima de Tailwind v4
# (next session lo hace siguiendo DESIGN_BRIEF.md)
```

### Checklist al final del rediseño

- [ ] 5 rutas devuelven 200
- [ ] 1 solo `<h1>` por página
- [ ] HTML semántico
- [ ] `prefers-reduced-motion` respetado
- [ ] Mobile no roto
- [ ] `npm run build` sin errores
- [ ] `php artisan migrate:fresh --seed` corre limpio
- [ ] Carrito visualmente contemplado, no funcional
- [ ] Sin lógica en `web.php`
- [ ] Sin imágenes remotas
- [ ] Lighthouse perf ≥ 80 en mobile
- [ ] Lighthouse a11y ≥ 90

---

## 5. Archivos relevantes

```
docs/
├── HANDOFF.md              ← este archivo (contexto operativo)
├── DESIGN_BRIEF.md         ← decisiones de diseño cerradas + investigación
└── NEXT_SESSION_PROMPT.md  ← prompt copy-paste para la próxima sesión

app/                        ← back, no tocar
config/                     ← Laravel default + adaptaciones, no tocar
database/                   ← migrations + seeders + sqlite, no tocar
routes/web.php              ← 5 rutas, no tocar
public/images/              ← carpetas vacías para futuros assets
README.md                   ← tecnologías y comandos, mantener
datos.txt                   ← plantilla académica, completar antes de entregar
```
