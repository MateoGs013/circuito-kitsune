# Circuito Kitsune

Tienda ficticia académica de máscaras japonesas cyberpunk. Cada máscara representa una identidad nocturna que abre un distrito de la ciudad bajo vigilancia. La sección **Transmisiones** es el blog del circuito (guías, sistemas, novedades).

Trabajo práctico — Primer Parcial — *Portales y Comercio Electrónico*.

> **Documentación clave**:
> - `docs/DESIGN_BRIEF.md` — spec absoluta cerrada (2346 líneas, 80 reglas numeradas, 5 páginas, 3 anti-patterns documentados).
> - `docs/PROGRESS.md` — estado real de implementación + desviaciones del brief + acceptance verificado.
> - `docs/NEXT_SESSION_PROMPT.md` — handoff para sesiones nuevas.

## Concepto

- **Productos**: 6 máscaras del catálogo (Kitsune, Oni, Karasu, Neko, Sakura, Ronin), cada una con su distrito.
- **Transmisiones**: 5 notas editoriales con tono clandestino-técnico.
- **Carrito**: contemplado visualmente con drawer Alpine, **NO funcional**. Copy honesta: *"el carrito se abre en la próxima fase del circuito"*.

## Stack

| Tecnología | Para qué |
|---|---|
| **Laravel 13** | MVC, ruteo, Eloquent, migrations, seeders. |
| **Blade** | Plantillas + 5 componentes propios. |
| **Tailwind CSS v4** | `@tailwindcss/vite`. Tokens declarados en `@theme` de `app.css`. |
| **Alpine.js 3** | Estado UI mínimo (`cartOpen`). |
| **Lenis 1.3** | Smooth scroll, guardado por `prefers-reduced-motion`. |
| **GSAP 3** | Reservado para reveals avanzados (no usado en MVP). |
| **Playwright** | Screenshots automáticos a 4 viewports (`_research/shoot-*.mjs`). |
| **Vite 7** | HMR + build optimizado. |
| **SQLite** | DB local (`database/database.sqlite`). |
| **Google Fonts** | Archivo Black + Inter + IBM Plex Mono + Shippori Mincho B1 (4 familias). |

## Sistema visual

Paleta cerrada en `@theme` (`resources/css/app.css`):

| Token | Valor | Rol |
|---|---|---|
| `--color-ink` | `#14171F` | bg dominante |
| `--color-bone` | `#EBE5CE` | texto sobre ink |
| `--color-ember` | `#FF1919` | accent crítico, bg block-ember |
| `--color-ash` | `#252525` | divisores, scan-grid sobre ink |
| `--color-bone-dim` | `#8A8576` | texto secundario, mono labels |
| `--color-ink-soft` / `--color-ink-deep` | `#1E222D` / `#0A0C12` | hover bg / overlays |

4 familias tipográficas, 4 cromáticos principales + 3 derivados, 6 glow-only por producto (`R10`).

## Estructura MVC

```
app/
├── Http/Controllers/
│   ├── HomeController.php          # index() → home con destacados
│   ├── ProductController.php       # index + show
│   └── PostController.php          # index + show
├── Models/
│   ├── Product.php                 # scopes featured/available/byFilter, route key 'slug'
│   └── Post.php                    # scopes featured/published, route key 'slug'
└── Services/
    └── FeaturedContentService.php

database/
├── migrations/
│   ├── ..._create_products_table.php
│   └── ..._create_posts_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── ProductSeeder.php           # 6 máscaras
    └── PostSeeder.php              # 5 transmisiones

resources/
├── css/app.css                     # @theme + clases tipográficas + secciones + componentes
├── js/app.js                       # Alpine + Lenis + IntersectionObserver reveal
└── views/
    ├── layouts/app.blade.php       # head, header fixed, main, footer, cart drawer
    ├── components/
    │   ├── bracket-cta.blade.php   # CTA con corner brackets reales
    │   ├── marquee.blade.php       # track recursivo CSS
    │   ├── mask-portrait.blade.php # img WebP o SVG por tipo
    │   ├── stat-block.blade.php    # número display + label mono
    │   └── system-tag.blade.php    # ▸ + dot ember
    ├── home.blade.php              # 8 secciones § 8.1 (Opción C)
    ├── products/
    │   ├── index.blade.php         # § 8.2
    │   └── show.blade.php          # § 8.3 (4 secciones)
    └── posts/
        ├── index.blade.php         # § 8.4
        └── show.blade.php          # § 8.5

public/images/products/             # 6 WebP del cliente (~810 KB)

routes/web.php                      # 5 rutas, sin lógica
```

## Rutas

| Método | URL | Acción | Nombre |
|---|---|---|---|
| GET | `/` | `HomeController@index` | `home` |
| GET | `/productos` | `ProductController@index` | `products.index` |
| GET | `/productos/{product:slug}` | `ProductController@show` | `products.show` |
| GET | `/transmisiones` | `PostController@index` | `posts.index` |
| GET | `/transmisiones/{post:slug}` | `PostController@show` | `posts.show` |

`/productos` acepta `?filter=` con: `disponibles`, `proximas`, `agotadas`, `raras`, `legendarias`. La lógica vive en `Product::scopeByFilter()` — sin lógica en `web.php`.

## Comandos

```powershell
# (PowerShell) PATH para PHP/Composer
$env:PATH = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;C:\laragon\bin\composer;" + $env:PATH

composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev               # terminal 1 (Vite HMR)
php artisan serve         # terminal 2 (Laravel :8000)
```

## Acceptance criteria § 12

Verificación detallada en `docs/PROGRESS.md`. Resumen:

- [x] 5 rutas → 200, ruta inválida → 404.
- [x] `migrate:fresh --seed` corre limpio.
- [x] `npm run build` corre limpio. CSS gzip **10.48 KB** (< 80 KB), JS gzip **38.6 KB** total (< 100 KB).
- [x] Responsive verificado a 390 / 1440 / 1920 / 2560 (capturas en `tmp-screenshots/full/`).
- [x] 4 familias tipográficas, 4 tokens cromáticos.
- [x] 1 `<h1>` por página, jerarquía sin saltos, semántica completa.
- [x] Focus visible global, skip link, `prefers-reduced-motion` cortando animaciones.
- [x] Sin `font-style: italic`, sin `border-radius` en cards.
- [x] Wall asimétrico real R35 (no grid uniforme).
- [x] Frame brackets ASCII reales (pseudo-elements).
- [x] Marquee recursivo en hero + featured-mask + closing (3 secciones).
- [x] HUD details (status corner, hash, coords, signal-meter).

## Carrito

Drawer Alpine que slide-in al click en `[ CARRITO 00 ]`. Estado puramente visual. Copy:

> Tu archivo está vacío. El carrito se abre en la próxima fase del circuito.

Único CTA del drawer: "VER EL ARCHIVO" → `/productos`. Sin `<form>` checkout, sin localStorage, sin modelo `CartItem`.

## Notas de diseño

El sistema visual sigue el lenguaje **Utopia Tokyo** (paleta `#14171F` + `#FF1919` + `#EBE5CE`, brutalismo geom uppercase, frame brackets ASCII, marquees recursivos, status corners) pero con **arquitectura Opción C**: home con 8 secciones propias de CK incluyendo 3 que Utopia no tiene (stats globales, mapa de distritos, última transmisión destacada). Detalles en `docs/DESIGN_BRIEF.md` § 1.4 / § 2.4 / § 2.5.

Las tipografías son las equivalentes free de Google Fonts a las que usa Utopia (paid):

| Utopia (paid) | CK (free Google Fonts) |
|---|---|
| PPMori 700 | Archivo Black 900 |
| PPMori 600 | Inter 500 |
| Zpix | IBM Plex Mono 500 |
| (CJK implícito) | Shippori Mincho B1 |
