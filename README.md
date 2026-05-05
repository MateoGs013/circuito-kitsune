# Circuito Kitsune

Tienda académica de máscaras urbanas cyber-folk para los distritos nocturnos del **Circuito Kitsune**. Cada máscara funciona como una identidad: define por qué corredores podés moverte y a qué horas. La sección **Transmisiones** es el blog del circuito (guías, reportes y protocolos para nuevos usuarios).

Trabajo práctico — Primer Parcial — *Portales y Comercio Electrónico*.

## Concepto

- **Productos**: máscaras del catálogo, cada una asociada a un distrito y a una familia (Kitsune, Oni, Karasu, Neko, Sakura, Ronin).
- **Transmisiones**: notas y guías cortas con tono editorial.
- **Carrito**: contemplado **visualmente** en el header y en la ficha de producto, pero **no implementado** todavía. La etiqueta y el botón están desactivados a propósito.

## Tecnologías

| Tecnología | Para qué se usa |
|---|---|
| **Laravel 13** (`Laravel Framework 13.7.0`) | Framework principal. Provee el patrón **MVC**, ruteo, ORM (Eloquent), migrations y seeders. |
| **Blade** | Motor de plantillas. ~11 componentes propios (`x-mask-placeholder`, `x-mask-node`, `x-mask-dossier`, `x-product-card`, `x-post-card`, `x-stat-meter`, `x-access-button`, `x-circuit-section-heading`, `x-system-label`, `x-terminal-line`, `x-badge`). |
| **Tailwind CSS v4** | Framework de utilidades CSS. Configurado vía `@tailwindcss/vite` (esquema oficial de Laravel 13, sin `tailwind.config.js`). |
| **CSS custom** | Sistema visual propio en `resources/css/app.css`: tokens `--ck-*` (paleta cyberpunk-japonesa) declarados en `@theme`, utilidades `.ck-grid-bg`, `.ck-noise`, `.ck-scanline`, `.ck-panel`, `.ck-panel-corners`, `.ck-glow-*`, `.ck-terminal-label`. |
| **Alpine.js 3** | Interactividad mínima en cliente: estado de activación en home, ficha activa en el mapa de identidades. Todo sigue siendo usable sin JS (los nodos son `<a>` reales). |
| **Google Fonts** (Space Grotesk + JetBrains Mono) | Tipografía: display sans para títulos, mono para datos técnicos y códigos del sistema. |
| **Vite** | Bundler para CSS y JS. Hot reload en `npm run dev`, build optimizado en `npm run build`. |
| **SQLite** | Base de datos local por default (archivo `database/database.sqlite`). Sin servidor externo necesario para correr el proyecto. |

## Sistema visual

Paleta `--ck-*` declarada como `@theme` en `resources/css/app.css`. Eso genera utilidades Tailwind automáticamente: `bg-ck-bg`, `text-ck-cyan`, `border-ck-line`, etc. Las variables clave:

| Token | Valor | Uso |
|---|---|---|
| `--color-ck-bg` | `#03050B` | fondo global azul-negro profundo |
| `--color-ck-panel` | `#0A1324` | paneles técnicos |
| `--color-ck-cyan` | `#00E5FF` | acento principal, cursores, links activos |
| `--color-ck-magenta` | `#FF2DAA` | acento secundario |
| `--color-ck-text` / `--color-ck-muted` | `#EAF7FF` / `#7C8EA3` | textos primario / secundario |

Las utilidades `.ck-panel-corners` agregan corner brackets via pseudo-elementos; `.ck-scanline` agrega líneas finas estilo CRT; `.ck-grid-bg` da una grilla técnica de fondo. Todas respetan `prefers-reduced-motion`.

## Estructura MVC

```
app/
├── Http/Controllers/
│   ├── HomeController.php          # index(): arma el home con destacados
│   ├── ProductController.php       # index + show de productos
│   └── PostController.php          # index + show de transmisiones
├── Models/
│   ├── Product.php                 # Eloquent, scope featured(), route key 'slug'
│   └── Post.php                    # Eloquent, scope featured(), route key 'slug'
└── Services/
    └── FeaturedContentService.php  # extrae destacados (separa lógica del controller)

database/
├── migrations/
│   ├── 2026_05_04_000001_create_products_table.php
│   └── 2026_05_04_000002_create_posts_table.php
└── seeders/
    ├── DatabaseSeeder.php          # llama a ProductSeeder y PostSeeder
    ├── ProductSeeder.php           # 6 máscaras iniciales
    └── PostSeeder.php              # 5 transmisiones iniciales

resources/views/
├── layouts/app.blade.php           # layout base con header + carrito visual
├── home.blade.php
├── products/{index,show}.blade.php
├── posts/{index,show}.blade.php
└── components/{product-card,post-card,badge}.blade.php

routes/web.php                      # solo declara rutas, sin lógica
```

`routes/web.php` no tiene lógica de negocio: cada ruta apunta a un controller.

## Rutas principales

| Método | URL | Acción | Nombre |
|---|---|---|---|
| GET | `/` | `HomeController@index` | `home` |
| GET | `/productos` | `ProductController@index` | `products.index` |
| GET | `/productos/{product:slug}` | `ProductController@show` | `products.show` |
| GET | `/transmisiones` | `PostController@index` | `posts.index` |
| GET | `/transmisiones/{post:slug}` | `PostController@show` | `posts.show` |

El catálogo acepta `?filter=` con estos valores: `disponibles`, `proximas`, `agotadas`, `raras`, `legendarias`. La lógica vive en el scope `Product::scopeByFilter()` — sin lógica en `web.php` ni en el controller (este último solo lee el query y pasa al scope).

## Comandos para correr

Desde la raíz del proyecto:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev          # en una terminal (Vite hot reload)
php artisan serve    # en otra terminal (servidor PHP, http://127.0.0.1:8000)
```

> En Windows / PowerShell, reemplazar `cp` por `Copy-Item .env.example .env`.

La base SQLite se crea sola (`database/database.sqlite`) — no hace falta MySQL. Si querés cambiar a MySQL, editá `.env` (`DB_CONNECTION=mysql`, etc.).

## Assets visuales

El proyecto **no necesita imágenes para correr**. Cada producto tiene un `image_path` previsto, pero si el archivo todavía no existe en `public/`, las vistas muestran un **placeholder visual** construido con CSS (fondo oscuro + código + rareza + acento de color dominante + leyenda *"Imagen pendiente de sincronización"*).

### Estructura de carpetas

```
public/images/
├── products/    # imágenes individuales de cada máscara
├── hero/        # portadas / banners (Fase visual)
└── textures/    # patterns y texturas reutilizables (Fase visual)
```

Las tres carpetas existen con un `.gitkeep` para que Git las preserve aunque estén vacías.

### Imágenes de producto

| Producto | Path esperado |
|---|---|
| Kitsune-01: Zorro de Neón | `public/images/products/kitsune-01-zorro-de-neon.webp` |
| Oni-09: Protocolo Rojo | `public/images/products/oni-09-protocolo-rojo.webp` |
| Karasu-07: Señal Negra | `public/images/products/karasu-07-senal-negra.webp` |
| Neko-03: Glitch de la Suerte | `public/images/products/neko-03-glitch-de-la-suerte.webp` |
| Sakura-404: Flor Rota | `public/images/products/sakura-404-flor-rota.webp` |
| Ronin-X: Último Pasajero | `public/images/products/ronin-x-ultimo-pasajero.webp` |

### Recomendaciones

- **Formato:** `.webp` (mejor compresión que JPG/PNG manteniendo calidad).
- **Tamaño:** `1024×1024` (cuadrado) o `1200×1600` (vertical 3:4). Las vistas usan `aspect-square` con `object-cover`, así que cualquier proporción se recorta limpiamente.
- **Peso objetivo:** menos de 200 KB por imagen.
- **Nombre:** debe coincidir exactamente con el `slug` del producto + `.webp`.

### Cómo reemplazar un placeholder por una imagen real

1. Generar/exportar la imagen como `.webp` con el nombre exacto del slug.
2. Copiarla a `public/images/products/`.
3. Recargar la página. No hace falta tocar la base, ni el seeder, ni el Blade: el método `Product::hasImage()` detecta automáticamente que el archivo existe y la vista cambia del placeholder a la imagen real.

Las imágenes de producto **no son obligatorias para correr el proyecto**: la Fase 1 está pensada para entregarse con o sin assets.

## Carrito (estado actual)

El carrito está **contemplado visualmente** pero **no implementado**:

- En el header hay un ícono de carrito con contador `0` y estado deshabilitado.
- En la ficha de producto hay un botón **"Agregar al carrito (próximamente)"** también deshabilitado.

No hay sesión de carrito, ni modelo `CartItem`, ni rutas `cart.*`. Esa parte queda fuera del alcance de esta entrega.

## Notas de diseño

La interfaz es **básica, limpia y legible** a propósito. Paleta neutra (negro/gris), tipografía sans, sin animaciones decorativas todavía. La identidad visual final no está dentro del alcance del primer parcial.
