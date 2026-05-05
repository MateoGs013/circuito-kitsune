# Circuito Kitsune

Tienda ficticia académica de máscaras japonesas cyberpunk. Cada máscara representa una identidad nocturna que abre un distrito de la ciudad. La sección **Transmisiones** es el blog del circuito (guías, sistemas, novedades).

Trabajo práctico — Primer Parcial — *Portales y Comercio Electrónico*.

## Concepto

- **Productos**: 6 máscaras del catálogo (Kitsune, Oni, Karasu, Neko, Sakura, Ronin), cada una con su distrito asignado.
- **Transmisiones**: 5 notas editoriales con tono clandestino-técnico.
- **Carrito**: contemplado visualmente con drawer Alpine, **NO funcional** (la consigna pide estructura para carrito, no implementación). Copy honesta: *"el carrito se abre en la próxima fase del circuito"*.

## Stack

| Tecnología | Para qué |
|---|---|
| **Laravel 13** | MVC, ruteo, Eloquent, migrations, seeders. |
| **Blade** | Plantillas + 5 componentes propios. |
| **Tailwind CSS v4** | `@tailwindcss/vite`. Tokens declarados en `@theme` de `app.css`. |
| **Alpine.js 3** | Estado UI mínimo (`cartOpen`). |
| **Lenis 1.3** | Smooth scroll, guardado por `prefers-reduced-motion`. |
| **GSAP 3** | Reservado para reveals avanzados. |
| **Vite 7** | HMR + build optimizado. |
| **SQLite** | DB local (`database/database.sqlite`). |
| **Google Fonts** | Archivo Black + Inter + IBM Plex Mono + Shippori Mincho B1. |

## Sistema visual

Paleta cerrada en `@theme` (`resources/css/app.css`):

| Token | Valor | Rol |
|---|---|---|
| `--color-ink` | `#14171F` | bg dominante |
| `--color-bone` | `#EBE5CE` | texto sobre ink |
| `--color-ember` | `#FF1919` | accent crítico, bg block-ember |
| `--color-ash` | `#252525` | divisores |
| `--color-bone-dim` | `#8A8576` | texto secundario |
| `--color-ink-soft` / `--color-ink-deep` | `#1E222D` / `#0A0C12` | hover bg / overlays |

4 familias tipográficas, 4 cromáticos principales + 3 derivados, 6 glow-only por producto (vía `dominant_color`).

## Estructura MVC

```
app/
├── Http/Controllers/
│   ├── HomeController.php
│   ├── ProductController.php
│   └── PostController.php
├── Models/
│   ├── Product.php                 # scopes featured/available/byFilter
│   └── Post.php                    # scopes featured/published
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
    │   ├── bracket-cta.blade.php
    │   ├── marquee.blade.php
    │   ├── mask-portrait.blade.php
    │   ├── stat-block.blade.php
    │   └── system-tag.blade.php
    ├── home.blade.php              # 8 secciones
    ├── products/
    │   ├── index.blade.php
    │   └── show.blade.php
    └── posts/
        ├── index.blade.php
        └── show.blade.php

public/images/products/             # 6 imágenes WebP

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

`/productos` acepta `?filter=` con: `disponibles`, `proximas`, `agotadas`, `raras`, `legendarias`. La lógica vive en `Product::scopeByFilter()`.

## Cómo correr el proyecto

```bash
composer install
copy .env.example .env          # Windows / PowerShell: Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build                   # build de assets para producción
php artisan serve               # servidor en http://127.0.0.1:8000
```

Para desarrollo con hot reload:
```bash
npm run dev                     # terminal 1 (Vite HMR)
php artisan serve               # terminal 2 (Laravel)
```

La base SQLite se crea sola en `database/database.sqlite`. No requiere MySQL ni servidor externo.

## Carrito

Drawer Alpine que slide-in al click en `[ CARRITO 00 ]`. Estado puramente visual. Copy:

> Tu archivo está vacío. El carrito se abre en la próxima fase del circuito.

Sin `<form>` checkout, sin `localStorage`, sin modelo `CartItem`. La estructura del producto (modelo `Product`, migración con `price`, `is_available`, `formattedPrice()`) deja el camino libre para implementar carrito en una fase posterior.

## Estructura de la base de datos

**`products`** (6 registros seedeados):
- `name`, `slug`, `code`, `category`, `rarity`, `district`, `price`
- `short_description`, `long_description`
- `dominant_color`, `status`
- `signal_level`, `agility`, `spirit`, `ferocity` (atributos numéricos)
- `image_path`, `is_featured`

**`posts`** (5 registros seedeados):
- `title`, `slug`, `excerpt`, `body`
- `category`, `author`
- `published_at`, `reading_time`, `cover_tone`, `is_featured`

Ambas tablas creadas con Migrations. Datos cargados con Seeders desde `DatabaseSeeder`.
