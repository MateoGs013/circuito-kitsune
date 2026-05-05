# Circuito Kitsune · Design Brief Absoluto

> **Versión 3.0 · 2026-05-05 · ajustada a Opción C (CK como producto propio con lenguaje Utopia)**
>
> **Estado**: cerrado. Regla absoluta. Si algo no está acá, default = **no hacerlo**. Si encontrás contradicción interna, gana la sección de número más bajo. Si encontrás ambigüedad real, **detenete y preguntá** antes de implementar.
>
> **Audiencia de este doc**: una sola persona — el frontend que va a implementar Circuito Kitsune sobre el back Laravel 13 ya estable. Ese frontend puede ser un humano o una IA. El doc está escrito para que **no haya margen de interpretación creativa** porque ya hubo 5 iteraciones fallidas por exceso de interpretación.
>
> **Cambio v2 → v3**: el brief v2 quedó sesgado a "clone con piel" — replicaba la estructura exacta del home de Utopia (manifesto → kanji monumental → wall → featured → closing). v3 corrige hacia **Opción C**: CK toma de Utopia el **idioma visual** (paleta, tipografía, densidad atmosférica, brutalismo) pero la **arquitectura de páginas es propia** y aporta secciones que Utopia no tiene (mapa de distritos, última transmisión destacada, stats globales).

---

## ÍNDICE

- [0. Cómo leer este documento](#0-cómo-leer-este-documento)
- [1. Producto y contexto](#1-producto-y-contexto)
- [2. Investigación de la referencia · Utopia Tokyo](#2-investigación-de-la-referencia--utopia-tokyo)
- [3. Apuntes de iteraciones fallidas · qué NO repetir](#3-apuntes-de-iteraciones-fallidas--qué-no-repetir)
- [4. Reglas absolutas — 80 items numerados](#4-reglas-absolutas)
- [5. Sistema visual cerrado](#5-sistema-visual-cerrado)
- [6. Componentes obligatorios](#6-componentes-obligatorios)
- [7. Layouts por viewport](#7-layouts-por-viewport)
- [8. Contenido por página](#8-contenido-por-página)
- [9. Motion](#9-motion)
- [10. Accesibilidad WCAG AA](#10-accesibilidad-wcag-aa)
- [11. Performance targets](#11-performance-targets)
- [12. Acceptance criteria · checklist verificable](#12-acceptance-criteria)
- [13. Proceso de trabajo · cómo iterar](#13-proceso-de-trabajo)
- [14. Anexos](#14-anexos)

---

## 0. Cómo leer este documento

### 0.1 Reglas del lector

1. **Las "Reglas absolutas" del § 4 son inviolables**. Ningún criterio estético derrota una regla absoluta. Si una regla absoluta produce un resultado feo, el problema es el sistema circundante, no la regla.

2. **Cuando dos secciones se contradicen, gana la más temprana**. Ejemplo: si § 5.2 dice "tipografía display = Archivo Black" y § 8.1.1 sugiere otra cosa para el hero, gana § 5.2.

3. **Los anti-patterns del § 3 son ejemplos de errores reales, no advertencias genéricas**. Cada uno ocurrió en una iteración previa. Repetirlos es regresión.

4. **Los valores numéricos cerrados son cerrados**. `21.33px` significa `21.33px`, no "alrededor de 21px". `clamp(0.875rem, 1.1vw, 1.125rem)` significa esa fórmula exacta.

5. **Si una regla parece arbitraria, leer la justificación**. Cada regla tiene un motivo derivado de la referencia o de un error pasado. Si después de leer la justificación seguís sin entender, **preguntar antes de implementar**.

6. **Las palabras tienen significado técnico**:
   - **"Edge-to-edge"** = el elemento ocupa el 100% del viewport horizontal sin margen ni max-width.
   - **"Block (sección)"** = una `<section>` que ocupa al menos `min-height: 100dvh` salvo que se especifique otra altura.
   - **"Manifesto"** = tipografía display brutalista en uppercase, peso 900, línea apretada.
   - **"Ambient"** = elementos decorativos de bg que viven en una capa con `pointer-events: none` y opacidad < 1.
   - **"HUD"** = elementos UI técnicos (status corners, hash, coords) en mono pixel pequeño.
   - **"Bracket CTA"** = botón con marcas de esquina ASCII `[ ]` visibles, tipo Utopia.
   - **"Scrambled"** = palabras con caracteres swap que se "descifran" en scroll.
   - **"Marquee"** = línea recursiva de texto que se desplaza horizontalmente.
   - **"Ink", "bone", "ember"** = nombres de los tokens de paleta. NO se usan como sinónimos de "negro", "crema", "rojo".

### 0.2 Cómo se lee la sintaxis del doc

- **Bloques `code`**: contenido literal (HTML, CSS, JS, valores).
- **Tablas**: relación clave/valor cerrada — no se modifica sin cambiar el doc.
- **Listas numeradas**: orden importa.
- **Listas con bullets**: orden no importa.
- **🚫**: prohibido absoluto.
- **✅**: obligatorio.
- **🟡**: condicional, depende de criterios listados.

### 0.3 Cómo aprueba el cliente

El cliente (Mateo) aprueba **una página por vez**. Una vez que `home.blade.php` está aprobada visualmente con screenshots de validación a 1440px, 1920px y 390px, recién entonces se pasa a `/productos`. **No se trabaja en paralelo en dos páginas**. No se trabaja en componentes que aún no están en uso visible. No se "deja apuntado" código que vamos a usar después.

Si una decisión del brief produce un resultado que el cliente rechaza, **se actualiza el brief antes de re-implementar**. El brief es la fuente de verdad. Las modificaciones al brief quedan registradas en § 14.4 con fecha y motivo.

---

## 1. Producto y contexto

### 1.1 Qué es Circuito Kitsune

Circuito Kitsune es una **tienda ficticia** de máscaras japonesas cyberpunk. Cada máscara representa una identidad nocturna que abre un distrito de la ciudad bajo vigilancia. La narrativa es ficción literaria de operador clandestino — no es e-commerce real, no es NFT, no es web3, no es videojuego.

El visitante del sitio:

1. Llega a una página manifesto (home).
2. Lee la propuesta narrativa.
3. Explora un archivo de 6 máscaras (catálogo).
4. Abre el expediente de una máscara (detalle).
5. Lee transmisiones (artículos editoriales que profundizan la ficción).
6. Eventualmente "reserva" una máscara — pero **el carrito no es funcional**, es contemplado visualmente. La copy lo explica honestamente: *"el carrito se abre en la próxima fase del circuito"*.

### 1.2 Audiencia

**Audiencia primaria**: docente de la materia académica que evalúa el TP. Espera ver:
- Stack Laravel 13 + MVC + Blade + Tailwind correctamente aplicados.
- Estructura HTML semántica + accesibilidad mínima.
- Mobile-first responsive sin romper.
- 1 `<h1>` por página, jerarquía heading correcta.
- Nada de "magia" que no se pueda explicar técnicamente.

**Audiencia secundaria** (intencional): otro frontend / diseñador que vea el sitio en portfolio. Espera ver:
- Tipografía con personalidad fuerte.
- Layouts editorialmente competentes (no e-commerce genérico).
- Motion intencional, no decorativo.
- Detalles cyberpunk-clandestinos coherentes y consistentes.

### 1.3 Constraints académicos · INMOVIBLES

Estas reglas vienen del enunciado del TP. **No se relajan por estética**:

| Regla | Verificación |
|---|---|
| Stack: **Laravel 13** + Blade + Tailwind | `composer.json`, `package.json`, `routes/web.php` |
| **MVC** respetado · controllers ≤ 10 líneas | `app/Http/Controllers/*` |
| **Migrations + seeders** corren limpio | `php artisan migrate:fresh --seed` exit 0 |
| **5 rutas** + 1 query-param de filtro | `routes/web.php` · 5 `Route::get` |
| **Sin lógica en `routes/web.php`** | grep en `routes/web.php` debe mostrar solo `Route::get(...)->name(...)` |
| **1 `<h1>` por página** | `grep -c '<h1' resources/views/PAGE.blade.php` = 1 |
| **HTML semántico**: `<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`, `<aside>` cuando aplique | revisión manual |
| **Mobile-first responsive** | breakpoints en `min-width`, no `max-width` |
| **`prefers-reduced-motion: reduce`** corta animaciones críticas | media query en CSS y JS guards |
| **Sin imágenes remotas** (CDN externo prohibido para assets de marca) | grep `https?://` en views (solo Google Fonts permitido) |
| **Carrito visual, no funcional** | sin `<form>` de checkout, sin localStorage de carrito, copy honesta |
| **`datos.txt`** completado por alumno antes de entrega | revisión manual (no es responsabilidad del frontend) |
| **`README.md`** con tecnologías + comandos | revisión manual |

### 1.4 Rol de Utopia Tokyo · referencia ESTÉTICA, no estructural

Después de 5 iteraciones acumulando deuda visual, el cliente confirmó que el **idioma visual de destino** es el del sitio `https://www.utopiatokyo.com/`. Pero la decisión cerrada (Opción C, ratificada el 2026-05-05) es **NO clonar la arquitectura del home de Utopia**. CK es un producto distinto.

#### 1.4.1 Lo que Utopia aporta a CK (estética compartida)

1. **Paleta cromática** idéntica: ink `#14171F` + bone `#EBE5CE` + ember `#FF1919` + ash `#252525`. Sin saturación multicolor.
2. **Familias tipográficas equivalentes**: display brutalista uppercase + body sans humanist + accent pixel mono + CJK serif. Detalle exacto en § 5.2.
3. **Densidad atmosférica**: HUD operator (status corners, hash, coords, version), marquee recursivo, scan-grid, frame brackets ASCII, microcopy técnica.
4. **Disciplina brutalista**: H1 en uppercase letter-spacing -2%, line-height ≤ 0.9, color block edge-to-edge invertible.
5. **Bracket CTAs** literales `[ TEXT ]`.
6. **Wall asimétrico** como pattern para presentar productos visualmente.
7. **Fricción intencional**: copy clandestina, taglines cortantes, prosa técnica.

#### 1.4.2 Lo que Utopia NO aporta a CK (arquitectura propia)

CK **no replica** el flow del home de Utopia (`manifesto → kanji monumental → wall → featured → closing`). CK tiene su propia arquitectura de 8 secciones (ver § 8.1) que aporta **3 secciones nuevas que Utopia no tiene**:

- **Stats globales del circuito** (franja con 4 números agregados).
- **Mapa de distritos** (grid 2×3 territorial — geo-céntrico, no objeto-céntrico).
- **Última transmisión destacada** (1 bloque protagónico, no 3 chiquitas en feed).

Y **descarta 2 secciones que Utopia sí tiene**:

- **Manifesto quote** (la frase "el circuito te lee" era importada de Utopia).
- **Kanji monumental + scrambled words** (sección con valor narrativo dudoso para CK; el patrón de kanji se conserva como decoración esquinera ocasional, no como sección protagónica — ver R22).

Lo que **NO se clona** está documentado exhaustivamente en § 2.5.

---

## 2. Investigación de la referencia · Utopia Tokyo

### 2.1 Inventario visual analizado

Las decisiones de este brief se basan en evidencia visual extraída de las siguientes capturas reales del sitio (`tmp-screenshots/ref-utopia-*.png`, conservadas localmente para consulta durante implementación):

| Captura | Vista | Uso para CK |
|---|---|---|
| `ref-utopia-00-warning.png` | Modal warning inicial · bloque rojo flat sobre bg ink, brackets ASCII en CTAs | Pattern de bracket CTAs § 6.5 |
| `ref-utopia-01-hero.png` | Hero principal · UTOPIATOKYO + manifesto MASKED.MARKED.WATCHED. + máscara HANNYA derecha | Layout home hero § 8.1.1 |
| `ref-utopia-02.png` | Sección manifesto · H2 condensed bold rojo de 7 líneas + máscara con RGB-split + kanji 想郷 vertical lateral | Sección manifesto § 8.1.2 |
| `ref-utopia-03.png` | Continuación manifesto + dock de máscaras pequeñas inferior + marquee | Footer marquee § 6.9 |
| `ref-utopia-04.png` | **Wall of masks** · grid asimétrico real de 10+ máscaras con frame brackets, KAPPA selected con brackets rojos | Pattern wall § 8.1.4 (clave) |
| `ref-utopia-05.png` | Kanji 東京 monumental rojo + ambient scrambled words + UTOPIA centro + globe icons esquinas + marquee | Pattern kanji-monumental § 8.1.3 (clave) |
| `ref-utopia-06.png` | Misma vista invertida (rojo bg / negro kanji) + ambient cyan | Pattern color-block-invert § 5.1.4 |
| `ref-utopia-08-bottom.png` | Closing rojo con galería horizontal de máscaras + H1 grande | Pattern closing § 8.1.7 |
| `ref-utopia-mobile-full.png` | Mobile completo · todo el flow apilado | Reglas responsive § 7 |
| `_research/ref-mobile-390-1.png` | Mobile mid-scroll · H2 manifesto rojo apilado + DATA_XXX tags rojos | Microcopy operator § 5.4 |

### 2.2 Datos técnicos extraídos del DOM

Inspección automatizada con Playwright headless (`_research/utopia-styles.json`). Datos REALES, no asumidos:

#### 2.2.1 Paleta de Utopia Tokyo (top 6 colores en uso)

| RGB | HEX | Conteo | Rol identificado |
|---|---|---|---|
| `rgb(20, 23, 31)` | `#14171F` | 1782 | **Ink** — bg dominante, texto sobre rojo |
| `rgb(235, 229, 206)` | `#EBE5CE` | 1441 | **Bone** — texto sobre ink |
| `rgb(255, 25, 25)` | `#FF1919` | 907 | **Ember** — bg hero rojo, accent crítico |
| `rgb(37, 37, 37)` | `#252525` | 327 | **Ash** — separadores tenues, scan-grid |
| `rgba(20, 23, 31, 0.2)` | `#14171F33` | 1221 | Ink al 20% — overlays |
| `rgba(235, 229, 206, 0.2)` | `#EBE5CE33` | 575 | Bone al 20% — bordes tenues |

**Cyan no aparece como color hex en la paleta**. El "cyan" visible en las capturas (palabras scrambled tipo `TOKUV`, `WHEIR`) es un **artefacto de filter/text-shadow** durante la animación scrub, no un color del sistema. **CK no adopta cyan como acento**. Si un efecto glitch transient introduce cyan, es de filter, no de paleta.

#### 2.2.2 Tipografía de Utopia Tokyo

| Familia | Conteo | Rol |
|---|---|---|
| `PPMori, Arial, sans-serif` | 2385 | Primary — H1/H2/body. Weight 600 default, 700 impact. **Geom bold display.** |
| `Zpix, Arial, sans-serif` | 301 | Pixel mono — taglines `[ENTER]`, microcopy operator |
| `Neopixel, Arial, sans-serif` | 49 | Pixel secundario |
| `Zpix, monospace` | 12 | Mono variant |
| `"PP Neue Montreal"` | 2 | Subtitle ocasional |
| `"Times New Roman"` | 2 | Fallback excepcional |

**PPMori NO es condensed**. Es bold display geométrico de proporciones normales. Más cercano a Archivo Black o Druk Wide que a Bebas Neue.

#### 2.2.3 Tamaños tipográficos clave

| Elemento | Font | Size (px) | Weight | Line-height | Letter-spacing |
|---|---|---|---|---|---|
| H1 hero `UTOPIATOKYO` | PPMori | **263.04px** | 600 | 199.91px (76%) | **-5.26px (-2%)** |
| H2 mid `EXPLORE MASKS...` | PPMori | **213.33px** | 700 | 192px (90%) | -4.27px (-2%) |
| H2 disclaimer `EXPERIENCE WARNING` | PPMori | **96px** | 700 | 100.8px (105%) | normal |
| Body párrafo | PPMori | **21.33px** | 600 | 27.73-29.87px (130-140%) | -0.21px (-1%) |
| Body large (footer step-in) | PPMori | **32px** | 600 | 40px (125%) | -0.64px (-2%) |
| Button disclaimer | PPMori | **17.07px** | 600 | normal | normal |
| Button accent `[ENTER]` | Zpix | **12.03px** | 400 | normal | normal |
| Tag link | PPMori | **14px** | 600 | normal | normal |

Observaciones críticas:

- El H1 hero corre a **263.04px** sobre viewport 1920 — eso es ~13.7vw. El H2 mid a 213.33px = 11.1vw. La escala usa **vw como base** para que escale fluidamente.
- **Letter-spacing siempre negativo** en headings grandes (-1% a -2%). En body chico también (-1%). Esto es deliberado — comprime ópticamente el bloque.
- **Line-height del H1 = 76% del font-size** (199.91 / 263.04). Eso es **lineas apretadas**, casi tocándose. CK debe replicarlo.
- **Weight 600 default** en body, no 400. Eso da peso visual. Inter o DM Sans en weight 500 son cercanos pero no idénticos.

### 2.3 Patrones identificados

Después de cruzar capturas + DOM data, identifiqué estos patrones repetidos a través del sitio:

#### 2.3.1 Patrón "color block edge-to-edge invertible"

Utopia alterna entre dos modos de color block en secciones consecutivas:
- **Modo Ink** (default): bg `#14171F`, texto bone `#EBE5CE`, acentos rojo `#FF1919`.
- **Modo Ember** (manifesto): bg `#FF1919`, texto ink `#14171F`, sin acentos secundarios.

La inversión es **edge-to-edge**: el bg ocupa el 100% del viewport horizontal. No hay max-width container que centre el bg. La transición entre secciones es **abrupta** — no hay degradados ni fades de color.

**Aplicación en CK**: hero, closing, y eventualmente algún call-out sectoriales en modo Ember. Resto en modo Ink.

#### 2.3.2 Patrón "tipografía como arquitectura"

El H2 en secciones manifesto **no es decoración** — es la estructura visual de la sección. Ocupa la mayor parte del viewport vertical, en uppercase, con line-height ≤ 90%, letter-spacing negativo, color rojo sobre ink (o ink sobre rojo).

Ejemplo: la frase `EXPLORE MASKS OF UTOPIA TOKYO WHERE PAST AND FUTURE COLLIDE` se descompone en **una palabra por línea**, todas en font-size enorme (213px / 1920 = 11vw), apiladas verticalmente. Eso ES la sección. No hay un párrafo "explicativo" después — la tipografía habla.

**Aplicación en CK**: sección manifesto del home (§ 8.1.2) y closing (§ 8.1.7).

#### 2.3.3 Patrón "kanji monumental como composición"

En la sección del kanji `東京` (`ref-utopia-05`), el kanji ocupa ~70% del viewport horizontal y vertical. NO es decoración esquinera. Es la pieza visual dominante. El bg es ink, el kanji es ember (o vice-versa).

Adicionalmente, hay una **eclipse circle** (un círculo del color del bg) superpuesta al centro del kanji que crea una composición tipo "amanecer japonés" técnico.

**Aplicación en CK**: sección 3 del home con el kanji `狐` (kitsune = zorro espíritu) (§ 8.1.3).

#### 2.3.4 Patrón "ambient scrambled words"

Alrededor del kanji monumental, en filas horizontales arriba y abajo, hay **palabras flotantes**. Estas palabras corresponden a una frase real que cuenta la narrativa del sitio. Cada palabra arranca **glitched** (caracteres swap, parcialmente cyan) y **se descifra al scroll**:

- Estado inicial: `MASKZ OF UTOPMT TOKUV WHEIR PABS ANH FUTWVS COLOCLU`
- Estado final: `MASKS OF UTOPIA TOKYO WHERE PAST AND FUTURE COLLIDE`

La animación es **scrub-driven** (atada al scroll), no a un timer.

**Aplicación en CK**: misma sección 3 del home con frase `ROSTROS DEL TURNO MÁSCARAS DEL CIRCUITO DONDE PASADO Y FUTURO SE CRUZAN BAJO SEÑAL ABIERTA`.

#### 2.3.5 Patrón "wall of identities asimétrico"

En la captura `ref-utopia-04`, el wall de máscaras es un **collage real**, no una grilla uniforme:

- ~10 máscaras de tamaños y posiciones distintos, no alineados a un grid 12-col.
- La máscara **selected** (KAPPA) tiene frame brackets rojos prominentes y un símbolo `+` arriba.
- Las otras máscaras tienen brackets más tenues (bone-dim) o ninguno.
- El nombre `KAPPA` aparece como display gigante encima del wall.

**Aplicación en CK**: sección 4 del home con las 6 máscaras del seeder (§ 8.1.4).

#### 2.3.6 Patrón "frame brackets ASCII reales"

Cada elemento clave (botones, máscaras, retratos hero) tiene **brackets ASCII visibles** en las esquinas:

```
┌──         ──┐
│              │
│   contenido  │
│              │
└──         ──┘
```

Los brackets son líneas finas (1px) en color contrastante (ember sobre ink, ink sobre ember). NO son borders completos del cuadro — son **marcas de esquina**, dejan los bordes laterales abiertos.

**Aplicación en CK**: § 6.5 (CTAs) y § 6.4 (mask portrait).

#### 2.3.7 Patrón "marquee recursivo inferior"

En el bottom de cada sección "kanji monumental" hay un marquee horizontal con texto recursivo en mono uppercase:

```
A REIMAGINED FUTURE, AND ANCIENT MASKS BECOME SYMBOLS OF UNTOLD POSSIBILITIES · HIDDEN HISTORIES CONVERGE WITH A REIMAGINED FUTURE...
```

Velocidad lenta (~30-40 segundos por loop completo), border-top + border-bottom 1px, padding vertical compacto.

**Aplicación en CK**: sección 3 (kanji monumental) y closing (§ 6.9).

#### 2.3.8 Patrón "HUD operator details"

El sitio está plagado de **detalles HUD chiquitos** en mono pixel:
- Coordenadas: `35.6762°N / 139.6503°E`
- Versión: `VERSION: 2.0.0-RC.1`
- Status: `[LOADING]`, `[READY]`, `[ONLINE]`
- Data tags: `DATA_INTELSTLP`, `DATA_SPIGEZ` (hashes random ficticios)
- Coords corner: `01—02—03` paginación
- Tags: `[ENTER UTOPIA]`, `[STAFF]`, `[KEAYS]`, `[X]`

Estos detalles aparecen en bg, en headers, en footers. **Nunca interfieren con la lectura** — siempre en mono pequeño (12-14px), color bone-dim sobre ink o ink sobre ember.

**Aplicación en CK**: presencia constante del HUD en todos los pages (§ 6.7, § 6.8).

#### 2.3.9 Patrón "loader cinematográfico"

Utopia tiene un preloader extenso (katanas cruzadas + chars rojos `[LOADING]` repetidos). **CK NO replica eso** — el TP académico tiene presupuesto perf de Lighthouse ≥ 80 mobile, un loader de 3-5 segundos lo destruye.

CK puede tener un **micro-overture < 1s** sólo en primera visita (sessionStorage), eso es todo.

#### 2.3.10 Patrón "modal disclaimer inicial"

Utopia abre con un `EXPERIENCE WARNING` modal que pide elegir entre `[ USE SAFE MODE ]` y `[ ENABLE GLITCH EFFECT ]`. Esa es una experiencia narrativa propia del sitio.

**CK NO replica esto**. Es ficción literaria del sitio referencia, no del nuestro. No tiene sentido pedirle al docente que "elija un modo".

### 2.4 Lo que SÍ tomar de Utopia (con justificación)

| Elemento | De Utopia | Adaptación CK | Justificación |
|---|---|---|---|
| Paleta `#14171F + #EBE5CE + #FF1919 + #252525` | ✅ Idéntica | ✅ Idéntica | Es el eje cromático que le da identidad. Cambiarla sería trabajar contra la referencia. |
| Tipografía display bold geom uppercase | ✅ PPMori 700 | ✅ Archivo Black 900 (Google Fonts, gratis, similar) | PPMori es paid. Archivo Black es la sustitución más cercana free. |
| Tipografía body sans humanist medium | ✅ PPMori 600 | ✅ Inter weight 500 (Google Fonts) | Inter es el reemplazo más cercano free para PPMori 600. |
| Pixel mono font para taglines/HUD | ✅ Zpix | ✅ VT323 (Google Fonts) | VT323 es pixel mono libre, single weight, similar feel a Zpix. |
| CJK kanji monumental | ✅ implícito en `想郷`, `霊京`, `東京` | ✅ Shippori Mincho B1 (Google Fonts) | Mantengo de iteraciones previas, es la mejor opción CJK free. |
| Color block edge-to-edge invertible | ✅ alternancia hero rojo / sección negra | ✅ Adoptado | Patrón clave de la referencia. |
| H2 manifesto descompuesto en líneas | ✅ EXPLORE / MASKS / OF / UTOPIA / TOKYO | ✅ Adoptado **solo en hero y closing** (R59) | Patrón clave. **NO replicar la sección kanji + scrambled** (descartada en Opción C). |
| Letter-spacing negativo en display | ✅ -2% en H1/H2 | ✅ Adoptado | Compresión óptica. |
| Line-height ≤ 90% en display | ✅ 76-90% | ✅ Adoptado | Bloques apretados. |
| Wall of masks asimétrico (collage) | ✅ ref-utopia-04 | ✅ Adoptado · es uno de los patrones más fuertes para CK | Reemplaza grid uniforme fallida en iteración E. Funciona perfecto para presentar las 6 máscaras. |
| Frame brackets ASCII reales | ✅ ubicuos | ✅ Adoptado | Detalle definitorio. |
| Bracket CTAs `[ TEXT ]` | ✅ ubicuos | ✅ Adoptado | Reemplaza `<button>` plano. |
| HUD details (coords, version, hash) | ✅ ubicuos | ✅ Adoptado, ficción CK | Densidad atmosférica. |
| Marquee recursivo inferior | ✅ en algunas secciones | ✅ Adoptado · usar en hero y closing | Pattern. |
| Tag VERSION + build hash | ✅ `VERSION: 2.0.0-RC.1` | ✅ `V.YY.MM · BUILD · 0xXXXXXX` (date-based) | Funciona narrativamente. |
| Globe icons esquinas | ✅ en kanji section | ✅ Adoptado, símbolo geom propio | Brand mark. |
| Featured mask hero individual con kanji | ✅ ref-utopia-02/03 (HANNYA gigante + kanji 想郷 lateral) | ✅ Adoptado en sección 4 home (§ 8.1.4) | Pieza protagónica para destacar producto del día. |

### 2.5 Lo que NO clonar de Utopia (con justificación)

| Elemento | De Utopia | Por qué NO en CK |
|---|---|---|
| 🚫 Modal disclaimer `EXPERIENCE WARNING` inicial | Sí | Es ficción narrativa propia de Utopia (ironía sobre vigilancia). En CK rompe el flujo académico. |
| 🚫 Preloader 3-5s con katanas + LOADING repeat | Sí | Mata Lighthouse perf ≥ 80 mobile. |
| 🚫 Sección kanji 東京 monumental + scrambled words | Sí (`ref-utopia-05`) | **Descartada en Opción C** — sección con peso visual desproporcionado al contenido funcional. El patrón de kanji se conserva solo como decoración esquinera ocasional (R22). |
| 🚫 Manifesto quote "El circuito te lee. Te asigna un distrito. Te devuelve una señal." | Sí (paráfrasis de Utopia) | **Descartada en Opción C** — frase importada. CK no usa quote section como sección protagónica. |
| 🚫 Frase scrambled words `MASKZ → MASKS` o paráfrasis CK | Sí | **Descartada en Opción C** — funcionalidad sin valor narrativo claro para CK. El efecto scramble queda como **post-MVP candidate** (§ 14.5). |
| 🚫 Eclipse circle composicional sobre kanji | Sí | **Descartada en Opción C** — composición específica de Utopia que no aporta a CK. |
| 🚫 Tagline literal traducida `MARCADO. ASIGNADO. DEVUELTO.` | Sí | **Descartada en Opción C** — traducción literal. CK usa retórica propia: `CADA NOCHE. UNA MÁSCARA. UN DISTRITO.` (R59 reformulada). |
| 🚫 Render 3D fotográfico de máscaras | Sí (avif assets) | CK usa **fotografías de máscaras tradicionales japonesas cyberpunk** subidas por el cliente (WebP en `public/images/products/{slug}.webp`). |
| 🚫 Glitch RGB-shift sobre TODA imagen | Sí en las máscaras | Demasiado pesado visualmente. CK lo aplica solo en hero featured y solo como filter sutil. |
| 🚫 Cyan secundario (`TOKUV`, `WHEIR`) | Sí en scramble | El cyan en Utopia es artefacto de filter, no de paleta. CK no agrega 5to color. |
| 🚫 Botón `[ RANDOM SELECTION ]` con animación dramática | Sí | Funcional pero no aporta. Si se quiere, queda como link plano `selección aleatoria` (§ 14.5). |
| 🚫 `Webflow` como stack | Webflow CMS | CK es Laravel + Blade. |
| 🚫 Versión `2.0.0-RC.1` mostrada literal | Sí | CK usa fecha del año + hash diario, no semver. |
| 🚫 Múltiples languages toggle (`JPN/EN`) | Sí | CK es solo español. |
| 🚫 PP Neue Montreal subtitle font | Sí (2 usos) | Innecesario para CK; su rol lo cumple Inter. |
| 🚫 Neopixel font como secundario pixel | Sí (49 usos) | CK usa solo VT323; agregar Neopixel sería inflar familias. |
| 🚫 Nombres de máscara en inglés (Hannya, Kappa, Tengu) | Sí | CK ya tiene 6 máscaras seeded con nombres en español: Kitsune-01, Oni-09, Karasu-07, etc. |
| 🚫 Estructura del home idéntica al flow de Utopia (manifesto → kanji → wall → featured → closing) | Sí | **Descartada en Opción C** — CK tiene 8 secciones propias (§ 8.1) con orden distinto y 3 secciones nuevas (stats globales, mapa de distritos, última transmisión). |

### 2.6 Diferencias estructurales · CK no es Utopia

Aunque la estética se alinea, la **arquitectura del producto** es distinta:

| Eje | Utopia Tokyo | Circuito Kitsune |
|---|---|---|
| Stack | Webflow CMS | Laravel 13 + Blade + Tailwind v4 |
| Páginas | 1 long-scroll page | 5 rutas (home, /productos, /productos/{slug}, /transmisiones, /transmisiones/{slug}) |
| Modelo de datos | Inline en CMS | DB SQLite con `products` + `posts` + relaciones |
| CMS | Webflow editor | Migrations + seeders fijos |
| Audiencia | Audiencia general (portfolio) | Docente académico + portfolio personal |
| Idioma | EN + JP toggle | ES único |
| E-commerce | No vende (es portfolio del estudio) | Carrito visual no funcional |
| Bundle | Webflow generado | Vite optimizado, presupuesto < 100 KB JS gzip |
| Motion library | Webflow interactions + custom | GSAP + Lenis (free) |

Estas diferencias condicionan cómo trasladamos los patrones:

- En lugar de **1 long-scroll**, distribuimos los patrones entre **5 vistas** (home concentra 5 secciones, las otras 4 son simplificaciones).
- En lugar de **1 modal de disclaimer**, una **micro-overture < 1s** opcional.
- En lugar de **selección random gamificada**, un link `selección aleatoria` plano (PHP `random()`).
- En lugar de **render 3D de máscaras**, **SVG ilustrado por tipo** con detalles propios (orejas zorro, cuernos oni, pico karasu, etc).

---

## 3. Apuntes de iteraciones fallidas · qué NO repetir

> Esta sección registra errores reales de las 5 iteraciones previas. **Cada item es una regresión a evitar.** Si encontrás un patrón que coincide, parar y revisar antes de implementar.

### 3.1 Iteración A · "editorial sumi sobrio" (descartada)

- **Síntoma del cliente**: *"muy genérica como para ir acorde con las máscaras"*, *"le falta cyberpunk en estética, no por colores"*.
- **Causa raíz**: interpreté "japonés editorial nocturno" como **minimalismo sumi** + Cormorant italic + Ma 間 generoso + 1 acento sutil. La referencia real es **brutalismo geom uppercase**.
- **Lección**: cuando el brief dice "japonés cyberpunk", **default a brutalismo tipográfico ANTES que a minimalismo editorial**. El editorial entra como contrapunto (body, quote), NO como master de UI.
- **🚫 Nunca**: usar serif italic como display dominante. El display es Archivo Black uppercase.

### 3.2 Iteración B · "cyberpunk con brackets sin radicalidad" (descartada)

- **Síntoma del cliente**: *"falta cyberpunk en estética"* — agregué status corners + frame brackets + scan-grid pero sobre layout sobrio.
- **Causa raíz**: agregué marcaje técnico **encima** de un layout editorial sumi. La densidad cyberpunk no compensa una arquitectura tipográfica equivocada.
- **Lección**: el cyberpunk es **arquitectura tipográfica + color block**, no decoración HUD. Si la H1 no es brutalista uppercase rojo sobre ink, no importa cuántos status corners agregues.
- **🚫 Nunca**: usar HUD details (status corners, hash, scan-grid) como "más estilo cyberpunk" si la jerarquía tipográfica sigue siendo editorial.

### 3.3 Iteración C · "Utopia adaptado tímido" (descartada)

- **Síntoma del cliente**: *"esta dirección sí te cierra? si es OK..."* (yo asumí que era OK, salté a otra sección sin confirmar).
- **Causa raíz**: hice un primer pase en dirección Utopia pero con paleta incorrecta (`#E63946` vermillion en lugar de `#FF1919`), tipografía Bebas Neue (condensed, no equivalente a PPMori), kanji chico en lugar de monumental.
- **Lección**: las decisiones de paleta y tipografía deben ser **idénticas a la referencia** (o el equivalente free más cercano), no "inspiradas en". Y nunca asumir aprobación sin que el cliente lo diga literalmente.
- **🚫 Nunca**: paleta vermillion `#E63946`. Es **`#FF1919`**.
- **🚫 Nunca**: Bebas Neue como display. Es **Archivo Black**.
- **🚫 Nunca**: kanji a tamaño "decorativo esquinero". O es monumental (>30vw) o no aparece.

### 3.4 Iteración D · "header con gradient confuso" (rechazada)

- **Síntoma del cliente**: *"el gradiente horrible del header que se confunde con el fondo"*.
- **Causa raíz**: agregué `linear-gradient(rgba(11,13,20,0.92) 0%, rgba(11,13,20,0) 100%)` al header pensando que daría legibilidad. Sobre rojo `#FF1919`, el gradiente queda como una **mancha negra desprolija** en el top.
- **Lección**: si el header tiene que vivir sobre múltiples colores de bg (ink y ember), debe tener un **bg sólido propio** (`#14171F`) con border-bottom 1px ash. **No gradientes sobre color block**.
- **🚫 Nunca**: header con `linear-gradient` o `backdrop-filter: blur` sobre block-ember. Solo bg sólido.

### 3.5 Iteración E · "wall uniforme grilla pareja" (rechazada)

- **Síntoma del cliente**: *"las máscaras aparecen las 6 una debajo de otra"* y luego *"el wall esta horripilante"*.
- **Causa raíz**: implementé el wall como **grid 12-col con cells del mismo tamaño en filas**. La referencia (`ref-utopia-04`) es **collage asimétrico** con tamaños drásticamente distintos.
- **Lección**: cuando el cliente dice "asimétrico", no es "un poco distinto" — es **drásticamente distinto** (factor 2x o más entre cells, posiciones no alineadas a una grilla regular).
- **🚫 Nunca**: wall de máscaras con cells del mismo tamaño en filas regulares.
- **🚫 Nunca**: grid uniforme cuando la referencia muestra collage.

### 3.6 Iteración F · "contrastes y visibilidad" (rechazada)

- **Síntoma del cliente**: *"no se ven"* sobre las ambient letters laterales y ciertos tags HUD.
- **Causa raíz**: usé `rgba(11,13,20,0.65)` sobre rojo, intentando "sutil pero presente". Sobre `#FF1919`, ese alpha 0.65 negro contrastea **muy bajo** (ratio ~3:1).
- **Lección**: sobre block-ember (`#FF1919`), el texto técnico **DEBE ser ink puro `#14171F`** (no alpha) o `bone` puro. Nada de "negro al 65%".
- **🚫 Nunca**: alpha < 1 en texto sobre rojo. Color completo o no se pone.

### 3.7 Iteración G · "scan-grid tímido" (corregida)

- **Síntoma del cliente**: *"no se ve la cuadricula"* sobre rojo.
- **Causa raíz**: scan-grid con líneas `rgba(11,13,20,0.16)` y dots 1.2px — invisible sobre rojo saturado.
- **Lección**: sobre block-ember, el scan-grid debe tener **alpha 0.45+** y dots de 2px+ con alpha 0.95 para que se lea.
- **🚫 Nunca**: scan-grid ash al 4% sobre rojo. Sobre rojo, scan-grid usa ink al 45%+.

### 3.8 Iteración H · "brief v2 sesgado a clone" (corregido en v3)

- **Síntoma del cliente**: *"el brief es para hacer un clone o hacer algo desde 0 pero con la estética de Utopia?"*
- **Causa raíz**: el brief v2 replicó la estructura exacta del home de Utopia (manifesto → kanji monumental → wall → featured → closing) + traducción literal de tagline (`MASKED.MARKED.WATCHED.` → `MARCADO.ASIGNADO.DEVUELTO.`) + paráfrasis de la frase scrambled. El resultado se leía como "Utopia con marca cambiada", no como producto propio.
- **Lección**: cuando se elige una referencia visual fuerte, hay que **distinguir entre idioma estético compartido y arquitectura específica**. CK puede compartir paleta + tipografía + densidad atmosférica + brutalismo con Utopia y aún así tener arquitectura propia. La opción C ratificada significa: tomar el lenguaje, descartar el flow, agregar secciones nuevas que justifiquen la existencia del proyecto como producto distinto.
- **🚫 Nunca**: importar la estructura completa de un sitio referencia. Tomar patrones específicos sí, replicar el flujo entero no.
- **🚫 Nunca**: traducir literalmente taglines / textos de la referencia. Usar retórica propia.

### 3.9 Patrones anti-pattern de proceso

Estos errores NO fueron de implementación visual sino de **proceso de trabajo**. Costaron muchas horas y tokens de iteración.

- **🚫 Saltar de tarea sin confirmación**: terminé el hero, asumí que estaba OK, salté al wall. El cliente: *"ni siquiera terminaste el hero"*.
  - **Regla**: una página/sección por vez. **Esperar confirmación literal del cliente** antes de pasar a la siguiente. "Si te parece OK..." no es confirmación.

- **🚫 Acumular cambios sin completar el anterior**: 5 iteraciones, cada una sumando capas (status corners + brackets + scan-grid + glitch + boot loader + ambient letters + marquee + ...) sin eliminar lo previo.
  - **Regla**: cuando una decisión visual es rechazada, **eliminar el código rechazado** antes de implementar la nueva versión. No mezclar.

- **🚫 Asumir suficiente lo que el cliente NO confirmó**: el cliente dice "me gusta más", yo lo interpreto como "todo OK seguí adelante".
  - **Regla**: "me gusta más" significa "vamos en buena dirección", no "esto está terminado".

- **🚫 Inventar features no pedidos**: agregué `[ SELECCIÓN ALEATORIA ]` y `boot loader` y `glitch flash` sin que el cliente los pidiera, basado en mi interpretación de la referencia.
  - **Regla**: solo implementar lo que está en este brief. Si una idea aparece en mitad de implementación, **anotarla en § 14.5 como "candidato post-MVP"** y seguir con lo aprobado.

- **🚫 Ignorar las herramientas que tengo a mano**: tenía Playwright instalado y screenshots de la referencia disponibles, pero seguí "imaginando" cómo se ve la referencia en lugar de inspeccionarla con `getComputedStyle`.
  - **Regla**: antes de redactar/implementar reglas visuales, **inspeccionar la referencia con herramientas reales** (Playwright, DevTools, color picker). Las suposiciones no valen.

- **🚫 Modo "ejecutor compulsivo"**: cuando el cliente está frustrado, redoblar implementación. Lo que hace falta es **parar y preguntar**.
  - **Regla**: si después de 2 correcciones del mismo punto el cliente sigue insatisfecho, **detenerse y preguntar qué está pasando** antes de tocar más código.

---

## 4. Reglas absolutas

> 80 reglas numeradas, agrupadas por categoría. Cada regla tiene justificación. Violar una regla absoluta no es "decisión creativa", es regresión.

### 4.1 Paleta y color (R1–R12)

**R1**. Los únicos colores cromáticos de marca son `--color-ink #14171F`, `--color-bone #EBE5CE`, `--color-ember #FF1919`, `--color-ash #252525`. Cualquier otro color en uso debe tener justificación documentada en este brief o ser un color del bg del retrato 3D (que ya está en el modelo `Product.dominant_color`).

**R2**. **🚫 Cyan no es un color de marca**. Aunque la animación scrub puede producir transientes cyan vía text-shadow/filter, no se declara `--color-cyan` ni se usa para UI standalone. Si una palabra glitched aparece en cyan, es efecto de animación, no token.

**R3**. **🚫 Vermillion `#E63946`** está prohibido. El rojo de CK es **`#FF1919`** exacto. Vermillion fue iteración A.

**R4**. **🚫 No introducir colores secundarios** "para variedad" (verde, azul, magenta, naranja). El sistema es 4 tokens. Si una sección parece monótona, el problema es la jerarquía tipográfica, no la falta de color.

**R5**. **Sobre `block-ember` (bg `#FF1919`), todo el texto debe ser `#14171F` puro**. Sin alpha, sin opacidad, sin filter. El contraste WCAG ink/ember = **5.96:1** (AA).

**R6**. **Sobre `block-ink` (bg `#14171F`), el texto principal es `#EBE5CE` puro** y los acentos son `#FF1919` puro. El contraste bone/ink = **15.2:1** (AAA), ember/ink = **4.99:1** (AA).

**R7**. **Texto secundario tenue (HUD labels, tags pequeños) usa `--color-ash #252525` solo sobre `#FF1919`** (contraste 1.06:1 — solo decorativo, nunca para info crítica) **o `--color-bone-dim` sobre ink**, donde `bone-dim` se define como `#8A8576` — bone reducido manualmente (NO `#EBE5CE` con alpha).

**R8**. **🚫 No usar alpha < 1 en texto crítico**. Los tokens con alpha (ink/20, bone/20) son SOLO para overlays decorativos (scan-grid, glow, frame), nunca para texto que el usuario debe leer.

**R9**. El **scan-grid sobre ink** usa líneas en `rgba(235, 229, 206, 0.04)` (cream al 4%). El **scan-grid sobre ember** usa líneas en `rgba(20, 23, 31, 0.45)` (ink al 45%) + dots ink-puro al 95% — porque sobre rojo el contraste óptico necesita ser mucho mayor.

**R10**. Los **dominant_color de cada producto** (cyan, red, violet, gold, magenta, blue del seeder) **solo aparecen como glow detrás del retrato** del producto en el detalle, **nunca como bg de sección, nunca como texto**. Mapeo:
```
cyan    → #22d3ee
red     → #ef4444
violet  → #8b5cf6
gold    → #f59e0b
magenta → #ec4899
blue    → #3b82f6
```
Estos hex pueden modular un radial-gradient con `opacity 0.18 + blur 32px` y nada más.

**R11**. El **focus ring** es `outline: 2px solid var(--color-ember); outline-offset: 4px;` en todo elemento interactivo. **🚫 No `outline: none`** sin reemplazo accesible.

**R12**. **Colores prohibidos absolutos**:
- `#000000` (negro puro) — usar `#14171F`.
- `#FFFFFF` (blanco puro) — usar `#EBE5CE`.
- `#E63946` (vermillion) — usar `#FF1919`.
- `#FF0000` (rojo Wall-of-Hell) — usar `#FF1919`.
- Cualquier color con saturación 100% que no sea `#FF1919`.

### 4.2 Tipografía (R13–R28)

**R13**. **4 familias tipográficas, cerradas**:
- `--font-display: "Archivo Black", "Arial Black", system-ui, sans-serif;`
- `--font-sans: "Inter", system-ui, sans-serif;`
- `--font-mono: "VT323", ui-monospace, "Courier New", monospace;`
- `--font-cjk: "Shippori Mincho B1", "Yu Mincho", serif;`

Las 4 se cargan vía Google Fonts CDN en el `<head>` del layout master con `preconnect` y `display=swap`.

**R14**. **🚫 No usar Bebas Neue** ni Anton ni ninguna condensed font. Las display de CK son **wide bold geom**, no condensed. Bebas/Anton son demasiado finas y altas, no replican PPMori.

**R15**. **🚫 No usar Cormorant Garamond** ni ninguna serif italic. CK es 100% sans + pixel + CJK. La estética editorial no es serif.

**R16**. **🚫 No usar Inter como display**. Inter es body. Display es Archivo Black exclusivamente.

**R17**. **Pesos disponibles por familia**:
- Archivo Black: solo 900 (no tiene otros).
- Inter: 400, 500, 600, 700.
- VT323: solo 400.
- Shippori Mincho B1: 400, 500, 700.

Si necesitás un peso intermedio, usar la familia que sí lo ofrece.

**R18**. **Letter-spacing en display brutalista es siempre negativo**:
- Display XL (clamp 4-13rem): `-0.02em` (-2%)
- Display L (clamp 2.5-7rem): `-0.018em` (-1.8%)
- Display M (clamp 1.5-3rem): `-0.012em` (-1.2%)
- Display S (clamp 1-1.5rem): `-0.005em` (-0.5%)

**R19**. **Line-height en display brutalista es ≤ 0.92**:
- Display XL: `0.86`
- Display L: `0.88`
- Display M: `0.92`
- Display S: `1.0` (cuando empieza a cumplir rol de subtitle)

**R20**. **Body Inter**:
- weight `500` por defecto.
- size: `clamp(0.95rem, 1.05vw, 1.125rem)` (~15-18px).
- line-height: `1.55`.
- letter-spacing: `-0.005em` (~-0.5%).
- color: `--color-bone` sobre ink, `--color-ink` sobre ember.

**R21**. **Mono VT323** (terminal pixel):
- size: `clamp(0.78rem, 0.9vw, 0.95rem)` (~12.5-15px).
- text-transform: **uppercase**.
- letter-spacing: `0.08em` (8% — VT323 es pixel, le sienta tracking suelto).
- line-height: `1.4`.
- weight: `400`.

**R22**. **CJK Shippori Mincho B1** uso permitido (Opción C):
- **Sutil esquinero** (decoración fragment en sección quote o aside): `font-size: clamp(6rem, 14vw, 14rem); opacity: 0.25; color: bone-dim`. Este es el uso default en CK.
- **Inline en feed** (números 壱 弐 参 肆 伍): `font-size: clamp(2rem, 3vw, 3rem); color: ember;`.
- **Individual en featured-mask hero** (sección 4 home): un kanji por máscara protagonizando la composición — `狐` (kitsune), `鬼` (oni), `烏` (karasu), `猫` (neko), `桜` (sakura), `浪` (ronin). Tamaño `clamp(14rem, 36vw, 36rem)`, color ember 33% opacity como fondo del retrato, NO sección protagónica completa.
- **🚫 No** sección kanji monumental como capítulo del home (descartado en Opción C — era patrón de Utopia replicado).
- **🚫 No** usar Shippori para body. **🚫 No** usar Shippori en mono labels.

**R23**. **Uppercase es obligatorio en**:
- Todo display (H1, H2, manifesto blocks).
- Todo mono (HUD, taglines, status corners, brackets, marquee).
- Subtítulos de sección (system tags `▸ ARCHIVO · 06`).
- **🚫 No** uppercase en body Inter (lecturabilidad).
- **🚫 No** uppercase en CJK (no aplica).

**R24**. **Tamaños tipográficos cerrados (escala fluida con clamp)**:

| Token CSS | Clamp | Min (mobile 360) | Max (1920+) |
|---|---|---|---|
| `--text-display-xl` | `clamp(3.5rem, 11vw, 14rem)` | 56px | 224px |
| `--text-display-lg` | `clamp(2.75rem, 8vw, 7.5rem)` | 44px | 120px |
| `--text-display-md` | `clamp(1.75rem, 3.4vw, 4rem)` | 28px | 64px |
| `--text-display-sm` | `clamp(1.25rem, 1.8vw, 2rem)` | 20px | 32px |
| `--text-body-lg` | `clamp(1.05rem, 1.2vw, 1.25rem)` | 17px | 20px |
| `--text-body` | `clamp(0.95rem, 1.05vw, 1.125rem)` | 15px | 18px |
| `--text-body-sm` | `clamp(0.85rem, 0.95vw, 1rem)` | 14px | 16px |
| `--text-mono` | `clamp(0.78rem, 0.9vw, 0.95rem)` | 12.5px | 15px |
| `--text-mono-sm` | `clamp(0.7rem, 0.78vw, 0.85rem)` | 11px | 13.6px |
| `--text-kanji-monumental` | `clamp(8rem, 28vw, 28rem)` | 128px | 448px |
| `--text-kanji-corner` | `clamp(6rem, 14vw, 14rem)` | 96px | 224px |

**R25**. **🚫 No usar `font-size: ___px` literal en blade**. Todos los tamaños vía variables CSS o clases utility tipo `text-display-xl`, `text-body`, etc. Si se necesita un tamaño que no está en la tabla, pedirle al brief que lo agregue.

**R26**. **🚫 No mezclar 2 display weights** en el mismo elemento. Archivo Black es 900. No hay 700 alternativo.

**R27**. **🚫 No usar `font-style: italic`** en CK. Ni en H, ni en body, ni en blockquote. La iteración A demostró que italic = sumi editorial = no es CK.

**R28**. **Headings semánticos**:
- 1 `<h1>` por página (constraint académico R1.3).
- `<h2>` para secciones top-level dentro de la página.
- `<h3>` para sub-secciones dentro de secciones.
- **🚫 No saltear niveles** (h1 → h3 sin h2).
- **🚫 No usar `<h_>`** para texto que no es heading (usar `<p>` con clase tipográfica).

### 4.3 Layout (R29–R44)

**R29**. **Edge-to-edge para color blocks**. Las secciones `block-ember` y `block-ink` ocupan `width: 100vw`. **🚫 No max-width** en la `<section>`.

**R30**. **Padding lateral fluido con clamp**:
```css
padding-left: clamp(1.25rem, 4vw, 5rem);
padding-right: clamp(1.25rem, 4vw, 5rem);
```
Aplicar al contenido interno de las secciones, no a la sección misma. La sección sigue edge-to-edge.

**R31**. **🚫 No `max-width` en `<main>`** ni en contenedores principales. El layout escala con el viewport. La única excepción es el `prose` del artículo (R37).

**R32**. **Hero secciones tienen `min-height: 100dvh`**, no `100vh`. `dvh` ajusta por la barra del browser mobile.

**R33**. **Layout interno hero**: `flex` con `flex-direction: row` en lg+, `column` en mobile. Columna izquierda = manifesto (text), columna derecha = retrato. **🚫 No grid 12-col** en hero — es flex con `flex: 1` para texto y `width: clamp(...)` para retrato.

**R34**. **Retrato del hero** tiene tamaño responsive:
```css
width: clamp(280px, 32vw, 620px);
aspect-ratio: 3 / 4;
```
**🚫 No** retrato con `max-width: 24rem` que se ve diminuto en ultrawide.

**R35**. **Wall of identities = collage asimétrico real**. 6 cells con tamaños drásticamente distintos:
- Cell featured (KITSUNE-01): `grid-column: 8 / 16; grid-row: 1 / 17;` (8 cols × 16 rows = grande).
- Otras cells: tamaños entre `3 cols × 8 rows` y `7 cols × 12 rows`, alternando.
- Grid base: `grid-template-columns: repeat(20, 1fr); grid-auto-rows: clamp(28px, 3.4vw, 52px); gap: clamp(8px, 0.9vw, 14px);`

**🚫 No** wall con cells del mismo tamaño en filas. **🚫 No** grid 6-col con cells iguales.

**R36**. **Mobile fallback del wall** (≤ 1023px): grid 2-col con cells uniformes 1/1, featured ocupa span 2.

**R37**. **Articles (transmisión show)**: `<article>` con `max-width: 64ch` centrado horizontalmente, padding lateral fluido. Esto es la única excepción a R31.

**R38**. **🚫 No usar `position: absolute`** para elementos críticos del layout (texto principal, CTAs). Solo para overlays atmosféricos (scan-grid, glow, ambient letters, frame brackets).

**R39**. **🚫 No usar `transform: translate` para posicionar layouts**. Solo para animar.

**R40**. **`<header>` es `position: fixed; top: 0; left: 0; right: 0;`** y tiene **bg sólido `var(--color-ink)`** + border-bottom 1px ash. **🚫 No** header con `mix-blend-difference`. **🚫 No** header con `linear-gradient`. **🚫 No** header con `backdrop-filter`.

**R41**. **Header height es `clamp(56px, 5vw, 72px)`**. El padding-top del primer `<section>` debe ser >= ese valor + un margen visual.

**R42**. **Footer es compacto**: `min-height: auto; padding: clamp(2rem, 4vw, 3rem) clamp(1.5rem, 5vw, 6rem);`. El footer NO ocupa altura monumental.

**R43**. **🚫 No anchos `100%` con padding y `box-sizing: content-box`**. Default es `border-box` (ya viene de Tailwind).

**R44**. **🚫 No nesting de `<section>` dentro de `<section>`** salvo cuando una `<section>` semánticamente subordinada lo justifique. Default es `<section>` → `<div>` → contenido.

### 4.4 Motion (R45–R52)

**R45**. **Stack motion cerrado**: Lenis (smooth scroll) + GSAP + ScrollTrigger (scrub-driven reveals). Alpine.js solo para state UI sencillo (`cartOpen`, `filterActive`).

**R46**. **🚫 No** SplitText premium de GSAP. Si necesitás split de palabras, lo hacés manual.

**R47**. **Easings cerrados**:
- `--ease-cinema: cubic-bezier(0.65, 0, 0.35, 1);` (default para todo lo no-spring)
- `--ease-out-cubic: cubic-bezier(0.33, 1, 0.68, 1);` (reveals)
- **🚫 No** ease-in-out lineal por default. Default es cinema.

**R48**. **Duraciones cerradas**:
- Hover: 380ms
- Reveal (entrada): 580-800ms (depende de stagger)
- Scrub (largo): 1200-1800ms
- Scramble word: 360-720ms
- **🚫 No** duraciones < 200ms (se pierden) ni > 2000ms (cansan).

**R49**. **Stagger**:
- Líneas de párrafo: 60ms
- Tarjetas en grilla: 90ms
- Palabras de scramble: 80ms
- **🚫 No** stagger > 200ms (se nota lento).

**R50**. **`prefers-reduced-motion: reduce`** corta TODO motion crítico. Implementación obligatoria:
- CSS: `@media (prefers-reduced-motion: reduce) { *,*::before,*::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } [data-reveal], [data-reveal-line] > span { opacity: 1 !important; transform: none !important; } .marquee__track { animation: none !important; } }`
- JS: `const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;` antes de inicializar Lenis, GSAP, scramble.

**R51**. **Hover effects mobile-safe**: usar `@media (hover: hover)` para guardarlos. **🚫 No** efectos hover en touch (se quedan stuck).

**R52**. **Cursor custom (dot+ring) opcional**, solo si todas las páginas están terminadas y queda tiempo. **🚫 No** cursor custom como prioridad antes de terminar el sitio.

### 4.5 Microcopy (R53–R60)

**R53**. **Voz**: clandestina técnica, no mística. *"el circuito te lee, te asigna un distrito y te devuelve una señal"* SÍ. *"adéntrate en el espíritu del zorro"* NO.

**R54**. **Idioma**: español rioplatense neutro. *"reservá"* sí (voseo), *"reserva"* también ok. **🚫 No** *"reservae"*, *"reservad"* (formas peninsulares).

**R55**. **Coordenadas siempre presentes**: `35.6762°N · 139.6503°E` (Tokyo) en al menos 1 lugar por página (header, footer, hero, status corner). En mono uppercase tracking-wide.

**R56**. **Versión y build hash decorativos**: cada page muestra `V.YY.MM · BUILD · 0xXXXXXX` donde el hash se genera de la fecha actual: `0x' . strtoupper(substr(md5(date('Ymd-Hi')), 0, 6))`. Sirve narrativamente como "versión activa del circuito".

**R57**. **Tags de status con bullet**: el patrón es `[bullet ember 6×6px] [label en mono uppercase]`. Ejemplo: `● ONLINE · TURNO NOCHE`.

**R58**. **Bracket CTAs literal**: el bracket de cada CTA es real, no `<button>` con `border`. Patrón: `[ TEXT ]` con corner brackets ASCII (`╔ ╗ ╚ ╝` o pseudo-elementos con border-top + border-side de 14px).

**R59**. **Tres-líneas manifesto cortante** · retórica propia, NO traducción literal. CK usa:
- **Hero**: `CADA NOCHE. UNA MÁSCARA. UN DISTRITO.` (3 frases cortas, descriptivas del producto, NO traducción de Utopia).
- **Closing**: `ELEGÍ TU TURNO. ABRÍ TU SEÑAL. ENTRÁ AL CIRCUITO.` (3 imperativos en voseo, retórica propia).
- 3 frases cortas, separadas en 3 líneas, **dot ember al final de cada frase**, todas en display-md uppercase.
- **🚫 No** taglines copiadas literal de Utopia. **🚫 No** `MARCADO. ASIGNADO. DEVUELTO.` (era v2 sesgado a clone, descartado en v3).

**R60**. **Carrito honesto**: la copy dice literalmente *"el carrito se abre en la próxima fase del circuito"* — nunca *"próximamente"* genérico, nunca *"reserva tu lugar"* engañoso.

### 4.6 Componentes (R61–R68)

**R61**. **5 componentes Blade obligatorios** (no más, no menos sin actualizar el brief):
- `<x-mask-portrait>` — placeholder SVG por tipo + soporte `image_path`
- `<x-bracket-cta>` — botón con corner brackets reales
- `<x-system-tag>` — `▸ LABEL · 02` con bullet ember
- `<x-stat-block>` — número grande + label mono + sufijo `/99`
- `<x-marquee>` — línea recursiva inferior

**R62**. **🚫 No crear componentes para "una sola vez"**. Si solo se usa en 1 página, va inline en esa page.

**R63**. **🚫 No crear componentes "por si los necesitamos"**. Solo se crea componente cuando hay 2+ usos reales.

**R64**. **Cada componente tiene props tipadas** vía `@props([...])` con defaults sensatos.

**R65**. **`<x-mask-portrait>`** detecta el tipo de máscara por `$product->slug` y renderiza un SVG distinto:
- `kitsune-*` → orejas zorro puntudas + marcas rojas frente
- `oni-*` → cuernos arriba + colmillos
- `karasu-*` → pico largo descendente + ojos pequeños
- `neko-*` → orejas pequeñas + bigotes laterales
- `sakura-*` → 5 pétalos circulares
- `ronin-*` → marco rectangular minimal sin cara

Si `$product->hasImage()` es true, usa `<img>` con `mix-blend-mode: luminosity` en lugar del SVG.

**R66**. **`<x-bracket-cta>`** renderiza:
```html
<a class="bracket-cta">
  <span>[</span><span>TEXT</span><span>]</span>
  <span class="cta-arrow">→</span>
</a>
```
con CSS que dibuja los brackets con pseudo-elementos `::before` y `::after`. El bracket es **visualmente prominente** (8-14% del ancho del botón).

**R67**. **`<x-system-tag>`** renderiza `<span><dot/><span>label</span></span>`. El dot es 6×6px ember.

**R68**. **`<x-stat-block>`** renderiza `<div><div>label</div><div>value/99</div></div>` con value en display-md y suffix en mono pequeño superscript.

### 4.7 Accesibilidad (R69–R76)

**R69**. **1 `<h1>` por página**, no más, no menos. Verificación: `grep -c '<h1' resources/views/PAGE.blade.php` = 1.

**R70**. **Jerarquía heading no skipea**: `<h1> → <h2> → <h3>`, no `<h1> → <h3>`.

**R71**. **HTML semántico obligatorio**:
- `<header>` (banner) único en layout master.
- `<nav aria-label="Navegación principal">` dentro del header.
- `<main id="main">` único, recibe el `@yield('content')`.
- `<section aria-labelledby="...">` o `<section aria-label="...">` para cada sección visible del scroll. Cada una con su heading dentro.
- `<article>` para cada item de feed o producto.
- `<footer>` (contentinfo) único en layout master.

**R72**. **Skip link**: primer elemento del `<body>`:
```html
<a href="#main" class="skip-link">Saltar al contenido</a>
```
Visible solo en focus. Estilo: bg ember, color ink, padding 0.75rem 1.25rem, top: -100px → top: 1rem en focus.

**R73**. **Focus visible**: `outline: 2px solid var(--color-ember); outline-offset: 4px;` en TODO elemento interactivo. **🚫 No `outline: none`** sin reemplazo.

**R74**. **Touch targets ≥ 44×44px** en mobile. Verificar con DevTools.

**R75**. **`aria-label` en botones sin texto**: el botón del carrito tiene `aria-label="Abrir carrito"`, los iconos sociales tienen `aria-label="Twitter"`, etc.

**R76**. **`alt` en imágenes obligatorio**. Mask portrait: `alt="{{ $product->name }}"`. Imágenes decorativas (scan-grid, glow): `aria-hidden="true"` (son SVG inline o pseudo-elementos, no `<img>`).

### 4.8 Performance (R77–R80)

**R77**. **Bundle JS gzip < 100 KB**. Verificable con `npm run build`.

**R78**. **Bundle CSS gzip < 80 KB**. Verificable con `npm run build`.

**R79**. **Imágenes (cuando existan en `public/images/products/`)** son **WebP** con `loading="lazy" decoding="async" width="..." height="..."`.

**R80**. **Lighthouse mobile target**: perf ≥ 80, a11y ≥ 90, best-practices ≥ 90, SEO ≥ 90.

---

## 5. Sistema visual cerrado

### 5.1 Paleta absoluta

#### 5.1.1 Tokens en CSS

```css
@theme {
    --color-ink: #14171F;        /* bg dominante */
    --color-ink-deep: #0A0C12;   /* solo overlays / fades extremos */
    --color-ink-soft: #1E222D;   /* hover bg, paneles elevados */
    --color-bone: #EBE5CE;       /* texto sobre ink */
    --color-bone-dim: #8A8576;   /* texto secundario, mono labels */
    --color-ash: #252525;        /* divisores, scan-grid sobre ink */
    --color-ember: #FF1919;      /* manifesto bg, accent crítico */
}
```

#### 5.1.2 Contrastes WCAG AA verificados

| Combinación | Ratio | WCAG AA | WCAG AAA |
|---|---|---|---|
| bone `#EBE5CE` sobre ink `#14171F` | 15.20:1 | ✅ | ✅ |
| ember `#FF1919` sobre ink `#14171F` | 4.99:1 | ✅ | 🟡 (large text only) |
| ink `#14171F` sobre ember `#FF1919` | 5.96:1 | ✅ | ✅ |
| ink `#14171F` sobre bone `#EBE5CE` | 15.20:1 | ✅ | ✅ |
| bone-dim `#8A8576` sobre ink | 5.49:1 | ✅ | 🟡 |
| ash `#252525` sobre ember | 1.04:1 | ❌ (decorativo) | ❌ |

**Reglas derivadas**:
- ember sobre ink solo para **texto grande** (display, ≥ 24px) o **iconografía**, no para body chiquito.
- ash es solo para scan-grid, separadores, frame brackets — **nunca para texto**.

#### 5.1.3 Reglas de uso por color

```
| Token        | Uso permitido                                     | Uso prohibido                       |
|--------------|---------------------------------------------------|--------------------------------------|
| ink          | bg sección default, texto sobre ember             | texto sobre bone (sí: solo en bone)  |
| bone         | texto sobre ink, bg cart drawer                   | bg de sección entera                 |
| ember        | bg block-ember, accent en headings, ctaprimary    | body text largo, scan-grid           |
| ash          | divisores, scan-grid, frame-brackets sutiles      | texto, fondos                        |
| bone-dim     | mono labels, status corners, captions             | bg, texto crítico                    |
| ink-deep     | boot loader, modal bg                             | secciones default                    |
| ink-soft     | hover bg, paneles elevated, cart-button           | texto                                |
```

#### 5.1.4 Patrón "color block invertible"

Las secciones del home alternan entre **2 modos** sin transiciones:

**Modo Ink** (default, mayoría de secciones):
```css
.block-ink {
    background: var(--color-ink);
    color: var(--color-bone);
    /* acentos = ember puro */
}
```

**Modo Ember** (hero + closing + ocasional call-out):
```css
.block-ember {
    background: var(--color-ember);
    color: var(--color-ink);
    /* texto = ink puro, sin alpha */
}
```

**Reglas de inversión**:
- En `block-ember`, el scan-grid pasa de ash sutil a **ink al 45%** (R9).
- En `block-ember`, los frame brackets pasan de bone a **ink puro**.
- En `block-ember`, los CTAs pasan de ember-ember a **ink-ink** (text + bracket).

### 5.2 Tipografía

#### 5.2.1 Familias cerradas

```css
@theme {
    --font-display: "Archivo Black", "Arial Black", system-ui, sans-serif;
    --font-sans: "Inter", system-ui, sans-serif;
    --font-mono: "VT323", ui-monospace, "Courier New", monospace;
    --font-cjk: "Shippori Mincho B1", "Yu Mincho", serif;
}
```

#### 5.2.2 Carga vía Google Fonts

En el `<head>` del layout:

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700&family=VT323&family=Shippori+Mincho+B1:wght@400;500;700&display=swap">
```

#### 5.2.3 Roles de cada familia

| Familia | Rol |
|---|---|
| **Archivo Black** | H1, H2 brutalista, manifesto blocks (3-líneas tagline). Solo weight 900. Solo uppercase. |
| **Inter** | Body text, párrafos, descripciones, labels grandes. Weights 400-700 disponibles, default 500. |
| **VT323** | Mono pixel — taglines `[ENTER]`, status corners, HUD details, marquee, hash, coords. Solo uppercase. Solo weight 400. |
| **Shippori Mincho B1** | Kanji monumental (`狐` en sección 3) y kanji esquineros decorativos (`壱`, `弐`, `参` en feed). |

#### 5.2.4 Escala completa con variables

```css
@theme {
    --text-display-xl: clamp(3.5rem, 11vw, 14rem);
    --text-display-lg: clamp(2.75rem, 8vw, 7.5rem);
    --text-display-md: clamp(1.75rem, 3.4vw, 4rem);
    --text-display-sm: clamp(1.25rem, 1.8vw, 2rem);

    --text-body-lg: clamp(1.05rem, 1.2vw, 1.25rem);
    --text-body: clamp(0.95rem, 1.05vw, 1.125rem);
    --text-body-sm: clamp(0.85rem, 0.95vw, 1rem);

    --text-mono: clamp(0.78rem, 0.9vw, 0.95rem);
    --text-mono-sm: clamp(0.7rem, 0.78vw, 0.85rem);
    --text-mono-xs: clamp(0.65rem, 0.72vw, 0.78rem);

    --text-kanji-monumental: clamp(8rem, 28vw, 28rem);
    --text-kanji-corner: clamp(6rem, 14vw, 14rem);
    --text-kanji-inline: clamp(2rem, 3vw, 3rem);
}
```

#### 5.2.5 Metrics por tamaño (line-height + letter-spacing)

```css
.t-display-xl {
    font-family: var(--font-display);
    font-size: var(--text-display-xl);
    line-height: 0.86;
    letter-spacing: -0.02em;
    text-transform: uppercase;
    font-weight: 900; /* default Archivo Black */
}

.t-display-lg {
    font-family: var(--font-display);
    font-size: var(--text-display-lg);
    line-height: 0.88;
    letter-spacing: -0.018em;
    text-transform: uppercase;
}

.t-display-md {
    font-family: var(--font-display);
    font-size: var(--text-display-md);
    line-height: 0.92;
    letter-spacing: -0.012em;
    text-transform: uppercase;
}

.t-display-sm {
    font-family: var(--font-display);
    font-size: var(--text-display-sm);
    line-height: 1.0;
    letter-spacing: -0.005em;
    text-transform: uppercase;
}

.t-body-lg {
    font-family: var(--font-sans);
    font-size: var(--text-body-lg);
    font-weight: 500;
    line-height: 1.55;
    letter-spacing: -0.005em;
}

.t-body {
    font-family: var(--font-sans);
    font-size: var(--text-body);
    font-weight: 500;
    line-height: 1.55;
    letter-spacing: -0.005em;
}

.t-body-sm {
    font-family: var(--font-sans);
    font-size: var(--text-body-sm);
    font-weight: 500;
    line-height: 1.5;
}

.t-mono {
    font-family: var(--font-mono);
    font-size: var(--text-mono);
    font-weight: 400;
    line-height: 1.4;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.t-mono-sm {
    font-family: var(--font-mono);
    font-size: var(--text-mono-sm);
    font-weight: 400;
    line-height: 1.35;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.t-kanji-monumental {
    font-family: var(--font-cjk);
    font-size: var(--text-kanji-monumental);
    line-height: 0.85;
    letter-spacing: -0.02em;
    color: var(--color-ember);
}

.t-kanji-corner {
    font-family: var(--font-cjk);
    font-size: var(--text-kanji-corner);
    line-height: 1;
    color: var(--color-bone-dim);
    opacity: 0.25;
}
```

#### 5.2.6 Reglas tipográficas operativas

- **🚫 No** `font-style: italic`.
- **🚫 No** `font-weight` que la familia no soporte (Archivo Black no tiene 700, no inventarlo).
- **🚫 No** `text-decoration: underline` por default — usar `border-bottom: 1px solid currentColor` con animation si hace falta.
- **🚫 No** ALL CAPS forzado en CSS para texto que ya viene en uppercase desde el HTML — confunde lectores de pantalla.

### 5.3 Espaciado

#### 5.3.1 Escala de espaciado fluido

```css
@theme {
    --space-3xs: clamp(0.25rem, 0.5vw, 0.5rem);   /* 4-8px */
    --space-2xs: clamp(0.5rem, 0.8vw, 0.75rem);   /* 8-12px */
    --space-xs: clamp(0.75rem, 1.2vw, 1rem);      /* 12-16px */
    --space-sm: clamp(1rem, 1.6vw, 1.5rem);       /* 16-24px */
    --space-md: clamp(1.5rem, 2.5vw, 2.5rem);     /* 24-40px */
    --space-lg: clamp(2.5rem, 4vw, 4rem);         /* 40-64px */
    --space-xl: clamp(4rem, 7vw, 7rem);           /* 64-112px */
    --space-2xl: clamp(6rem, 10vw, 10rem);        /* 96-160px */
    --space-3xl: clamp(8rem, 13vw, 13rem);        /* 128-208px */
}
```

#### 5.3.2 Padding lateral de secciones

```css
.section-padding-x {
    padding-left: clamp(1.25rem, 4vw, 5rem);
    padding-right: clamp(1.25rem, 4vw, 5rem);
}
```

Aplica al **contenido interno** de las secciones, NO a la sección misma (que sigue edge-to-edge para color block).

#### 5.3.3 Padding vertical de secciones

```css
.section-padding-y {
    padding-top: clamp(5.5rem, 7vw, 8rem);    /* deja espacio del header fixed */
    padding-bottom: clamp(2.5rem, 4vw, 4rem);
}
```

Las secciones que tienen marquee inferior pueden compensar reduciendo `padding-bottom` a `clamp(1rem, 2vw, 2rem)`.

### 5.4 Bordes y outlines

```css
.border-ash { border-color: var(--color-ash); }
.border-ember { border-color: var(--color-ember); }
.border-bone { border-color: var(--color-bone); }
.border-bone-dim { border-color: var(--color-bone-dim); }

.border-1 { border-width: 1px; }
.border-2 { border-width: 2px; }
```

**Reglas**:
- Default border en separadores: `1px solid var(--color-ash)`.
- Border de carrousel/wall cells: `1px solid var(--color-ash)` default, `1px solid var(--color-ember)` en hover/active.
- Border-radius default: **0**. CK no usa bordes redondeados salvo el dot del status corner (`border-radius: 50%`) y el círculo del status pulse (`border-radius: 50%`).
- **🚫 No** `border-radius` en cards, botones, secciones, retratos, frames.

### 5.5 Iconografía

CK no tiene un set de iconos completo. Las pocas piezas vectoriales son:

1. **Brand mark globe** (header derecha + izquierda en hero):
```html
<svg viewBox="0 0 56 32" fill="none" stroke="currentColor" stroke-width="1">
    <ellipse cx="28" cy="16" rx="26" ry="14"/>
    <line x1="2" y1="16" x2="54" y2="16"/>
    <line x1="28" y1="2" x2="28" y2="30"/>
    <ellipse cx="28" cy="16" rx="14" ry="14" stroke-width="0.6"/>
</svg>
```

2. **Cart icon** (header):
```html
<svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.2">
    <rect x="2" y="4" width="10" height="9"/>
    <path d="M5 4 V2.5 a2 2 0 0 1 4 0 V4"/>
</svg>
```

3. **Mask portrait SVGs** (6 tipos, ver R65 + § 6.4).

4. **Crosshair** (decorativo en sección kanji + retrato hero):
```html
<svg viewBox="0 0 12 12" fill="none" stroke="var(--color-ember)" stroke-width="1">
    <line x1="0" y1="6" x2="12" y2="6"/>
    <line x1="6" y1="0" x2="6" y2="12"/>
</svg>
```

5. **Frame corners** (no SVG, pseudo-elementos con border):
```css
.frame-corner--tl { border-top: 1px solid var(--color-bone); border-left: 1px solid var(--color-bone); }
/* ... tr, bl, br */
```

**🚫 No** importar libraries de iconos (Heroicons, Lucide, Feather). Lo que necesitemos lo dibujamos a mano.

### 5.6 Tokens CSS completos · estructura `@theme`

Resumen consolidado del `@theme` que debe ir en `resources/css/app.css`:

```css
@import "tailwindcss";

@theme {
    /* paleta */
    --color-ink: #14171F;
    --color-ink-deep: #0A0C12;
    --color-ink-soft: #1E222D;
    --color-bone: #EBE5CE;
    --color-bone-dim: #8A8576;
    --color-ash: #252525;
    --color-ember: #FF1919;

    /* tipografía */
    --font-display: "Archivo Black", "Arial Black", system-ui, sans-serif;
    --font-sans: "Inter", system-ui, sans-serif;
    --font-mono: "VT323", ui-monospace, "Courier New", monospace;
    --font-cjk: "Shippori Mincho B1", "Yu Mincho", serif;

    /* tamaños tipográficos */
    --text-display-xl: clamp(3.5rem, 11vw, 14rem);
    --text-display-lg: clamp(2.75rem, 8vw, 7.5rem);
    --text-display-md: clamp(1.75rem, 3.4vw, 4rem);
    --text-display-sm: clamp(1.25rem, 1.8vw, 2rem);
    --text-body-lg: clamp(1.05rem, 1.2vw, 1.25rem);
    --text-body: clamp(0.95rem, 1.05vw, 1.125rem);
    --text-body-sm: clamp(0.85rem, 0.95vw, 1rem);
    --text-mono: clamp(0.78rem, 0.9vw, 0.95rem);
    --text-mono-sm: clamp(0.7rem, 0.78vw, 0.85rem);
    --text-mono-xs: clamp(0.65rem, 0.72vw, 0.78rem);
    --text-kanji-monumental: clamp(8rem, 28vw, 28rem);
    --text-kanji-corner: clamp(6rem, 14vw, 14rem);
    --text-kanji-inline: clamp(2rem, 3vw, 3rem);

    /* espaciado */
    --space-3xs: clamp(0.25rem, 0.5vw, 0.5rem);
    --space-2xs: clamp(0.5rem, 0.8vw, 0.75rem);
    --space-xs: clamp(0.75rem, 1.2vw, 1rem);
    --space-sm: clamp(1rem, 1.6vw, 1.5rem);
    --space-md: clamp(1.5rem, 2.5vw, 2.5rem);
    --space-lg: clamp(2.5rem, 4vw, 4rem);
    --space-xl: clamp(4rem, 7vw, 7rem);
    --space-2xl: clamp(6rem, 10vw, 10rem);
    --space-3xl: clamp(8rem, 13vw, 13rem);

    /* easings + duraciones */
    --ease-cinema: cubic-bezier(0.65, 0, 0.35, 1);
    --ease-out-cubic: cubic-bezier(0.33, 1, 0.68, 1);
    --duration-hover: 380ms;
    --duration-reveal: 700ms;
    --duration-scrub: 1500ms;
}
```

---

## 6. Componentes obligatorios

> Solo 5 componentes Blade compartidos. Todo lo demás vive inline en su page específica.

### 6.1 Layout master · `resources/views/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#14171F">
    <meta name="description" content="@yield('meta_description', 'Tienda clandestina de máscaras japonesas cyberpunk.')">

    <title>@yield('title', 'Circuito Kitsune') · turno noche</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700&family=VT323&family=Shippori+Mincho+B1:wght@400;500;700&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ cartOpen: false }">

    <a href="#main" class="skip-link">Saltar al contenido</a>

    <header role="banner">
        {{-- ver § 6.2 --}}
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer role="contentinfo">
        {{-- ver § 6.3 --}}
    </footer>

    {{-- carrito drawer (visual) opcional, ver § 6.10 --}}

    @stack('scripts')
</body>
</html>
```

### 6.2 Header

**Estructura**:
- Brand mark globe (svg) izquierda + logo `CIRCUITO KITSUNE` Archivo Black uppercase.
- Centro (lg+): kanji 狐 sutil + label dinámico de sección actual (turno · noche / archivo · 06 / feed · transmisiones).
- Nav derecha: links `archivo`, `transmisiones`, botón `[ CARRITO 00 ]`, brand mark globe espejado.
- Position fixed top, bg `var(--color-ink)`, border-bottom 1px ash.
- Height: `clamp(56px, 5vw, 72px)`.
- Color texto: bone default, ember en hover y rutas activas.
- **🚫 No mix-blend-difference, no gradient, no backdrop-filter**.

### 6.3 Footer compacto

**Estructura**:
- 3 columnas: navegación / coordenadas / aviso del carrito.
- Bottom row: copyright + hash diario.
- Padding: `clamp(2rem, 4vw, 3rem)`.
- Border-top: 1px solid ash.
- Mono uppercase tracking-wide.
- Texto bone-dim, accent ember en links/hash.

### 6.4 `<x-mask-portrait>`

Ver R65 + capturas SVG por tipo (kitsune, oni, karasu, neko, sakura, ronin). Cada SVG tiene marcas características en el color del dominant_color del producto.

**Props**:
```php
@props([
    'product' => null,
    'alt' => null,
])
```

**Render**:
- Si `$product->hasImage()`: `<img>` con `mix-blend-mode: luminosity`.
- Si no: SVG inline según `$product->slug`.
- Border: 1px solid ash (default), aspect-ratio 3/4.
- Wrapper: `<figure>` con clase `mask-portrait`.

### 6.5 `<x-bracket-cta>`

**Render**:
```html
<a href="..." class="bracket-cta {{ $variant }}" data-glitch>
    <span class="bracket-cta__bracket-l">[</span>
    <span class="bracket-cta__text">TEXT</span>
    <span class="bracket-cta__bracket-r">]</span>
    <span class="bracket-cta__arrow">→</span>
</a>
```

**CSS**:
```css
.bracket-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.55em;
    padding: 0.85em 1.6em;
    font-family: var(--font-mono);
    font-size: var(--text-mono);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: currentColor;
    position: relative;
    transition: color var(--duration-hover) var(--ease-cinema),
                background-color var(--duration-hover) var(--ease-cinema);
    cursor: pointer;
}

.bracket-cta::before,
.bracket-cta::after {
    content: "";
    position: absolute;
    width: 14px;
    height: 100%;
    top: 0;
    border: 1px solid currentColor;
}
.bracket-cta::before { left: 0; border-right: none; }
.bracket-cta::after  { right: 0; border-left: none; }

.bracket-cta:hover,
.bracket-cta:focus-visible {
    background-color: currentColor;
}
.bracket-cta:hover > *,
.bracket-cta:focus-visible > * {
    mix-blend-mode: difference;
}
```

**Variants**:
- `.bracket-cta` default = color heredado del context.
- `.bracket-cta--ember` = color ember sobre block-ink.
- `.bracket-cta--ink` = color ink sobre block-ember.
- `.bracket-cta--bone` = color bone sobre block-ink.

### 6.6 `<x-system-tag>`

**Render**:
```html
<span class="system-tag">
    <span class="system-tag__dot" aria-hidden="true"></span>
    <span class="system-tag__label">{{ $label }}</span>
</span>
```

**CSS**:
```css
.system-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.55em;
    font-family: var(--font-mono);
    font-size: var(--text-mono-sm);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--color-bone-dim);
}
.system-tag__dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    background: var(--color-ember);
    border-radius: 50%;
}
.system-tag--pulse .system-tag__dot {
    animation: pulse-dot 2.4s var(--ease-cinema) infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(255, 25, 25, 0.55); }
    60% { opacity: 0.45; box-shadow: 0 0 0 8px rgba(255, 25, 25, 0); }
}
```

### 6.7 `<x-stat-block>`

**Render**:
```html
<div class="stat-block">
    <div class="stat-block__label">{{ $label }}</div>
    <div class="stat-block__value">
        {{ str_pad($value, 2, '0', STR_PAD_LEFT) }}<span class="stat-block__suffix">/99</span>
    </div>
</div>
```

**CSS**:
```css
.stat-block {
    border-left: 1px solid var(--color-ash);
    padding-left: 1rem;
}
.stat-block__label {
    font-family: var(--font-mono);
    font-size: var(--text-mono-xs);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--color-bone-dim);
    margin-bottom: 0.5rem;
}
.stat-block__label::before {
    content: "▸ ";
    color: var(--color-ember);
}
.stat-block__value {
    font-family: var(--font-display);
    font-size: clamp(2rem, 3.5vw, 3.5rem);
    line-height: 0.95;
    color: var(--color-bone);
}
.stat-block__suffix {
    font-family: var(--font-mono);
    font-size: 0.4em;
    color: var(--color-bone-dim);
    margin-left: 0.2em;
    vertical-align: 0.4em;
}
```

### 6.8 `<x-marquee>`

**Render**:
```html
<div class="marquee" aria-hidden="true">
    <div class="marquee__track">
        @for($i = 0; $i < 3; $i++)
            @foreach($items as $item)
                <span class="marquee__item">{{ $item }}</span>
                <span class="marquee__sep">·</span>
            @endforeach
        @endfor
    </div>
</div>
```

**CSS**:
```css
.marquee {
    overflow: hidden;
    border-top: 1px solid currentColor;
    border-bottom: 1px solid currentColor;
    padding: 0.55rem 0;
    font-family: var(--font-mono);
    font-size: var(--text-mono);
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.marquee__track {
    display: flex;
    gap: 3rem;
    white-space: nowrap;
    animation: marquee 38s linear infinite;
    will-change: transform;
}
.marquee__item { flex-shrink: 0; }
.marquee__sep { opacity: 0.6; }
@keyframes marquee {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-33.33%); }
}
@media (prefers-reduced-motion: reduce) {
    .marquee__track { animation: none; }
}
```

### 6.9 Frame brackets (mixin, no componente)

```css
.frame-brackets {
    position: relative;
    --bracket-color: var(--color-bone);
    --bracket-size: 18px;
    --bracket-offset: 0px;
}
.frame-brackets > .frame-corner {
    position: absolute;
    width: var(--bracket-size);
    height: var(--bracket-size);
    border-color: var(--bracket-color);
    border-style: solid;
    border-width: 0;
    pointer-events: none;
}
.frame-corner--tl {
    top: calc(-1 * var(--bracket-offset));
    left: calc(-1 * var(--bracket-offset));
    border-top-width: 1px;
    border-left-width: 1px;
}
.frame-corner--tr {
    top: calc(-1 * var(--bracket-offset));
    right: calc(-1 * var(--bracket-offset));
    border-top-width: 1px;
    border-right-width: 1px;
}
.frame-corner--bl {
    bottom: calc(-1 * var(--bracket-offset));
    left: calc(-1 * var(--bracket-offset));
    border-bottom-width: 1px;
    border-left-width: 1px;
}
.frame-corner--br {
    bottom: calc(-1 * var(--bracket-offset));
    right: calc(-1 * var(--bracket-offset));
    border-bottom-width: 1px;
    border-right-width: 1px;
}
```

### 6.10 Cart drawer (visual no funcional)

Drawer Alpine.js que slide-in desde la derecha al hacer click en `[ CARRITO 00 ]` del header.

**Estado interno** (puramente visual, no persiste):
- Items: 0 (siempre).
- Copy: "Tu archivo está vacío. El carrito se abre en la próxima fase del circuito."
- CTA único: "Ver el archivo →" → `/productos`.

```html
<aside x-cloak x-show="cartOpen"
       x-transition:enter="transition ease-out duration-500"
       x-transition:enter-start="translate-x-full"
       x-transition:enter-end="translate-x-0"
       class="cart-drawer"
       role="dialog" aria-modal="true" aria-labelledby="cart-title"
       @keydown.escape.window="cartOpen = false">
    <header>
        <x-system-tag :label="'CARRITO · 00 EXPEDIENTES'" />
        <h2 id="cart-title" class="t-display-md">Tu archivo<br>está vacío.</h2>
        <button @click="cartOpen = false" aria-label="Cerrar carrito">cerrar ✕</button>
    </header>
    <div>
        <p>El carrito se abre en la próxima fase del circuito. Por ahora podés explorar las máscaras del archivo y reservar señales.</p>
    </div>
    <a href="{{ route('products.index') }}" @click="cartOpen = false" class="bracket-cta">[ VER EL ARCHIVO → ]</a>
</aside>
```

---

## 7. Layouts por viewport

### 7.1 Mobile 360-430

- Padding lateral: `1.25rem` (= 20px).
- Display XL: 56px (`3.5rem`).
- Layout flex column siempre.
- Hero retrato: 280px ancho, abajo del manifesto.
- Wall: grid 1-col, cells uniformes 1/1 ratio.
- Marquee duración: 24s (lo más rápido es legible en mobile chico).
- Touch targets: ≥ 44×44px.
- Header height: 56px.

### 7.2 Tablet 768-1023

- Padding lateral: `2.5vw` (= 19-26px).
- Display XL: 84-112px.
- Layout flex column en hero + featured-mask.
- Wall: grid 2-col, featured span 2.
- Marquee duración: 30s.
- Header: kanji centro + label sección visible.
- Header height: 60px.

### 7.3 Laptop 1024-1439

- Padding lateral: `clamp(2.5rem, 4vw, 5rem)` (= 40-58px).
- Display XL: 112-158px.
- Layout flex row (hero, featured-mask).
- Wall: collage asimétrico activo (R35).
- Marquee duración: 36s.
- Header height: 64px.

### 7.4 Desktop 1440-1919

- Padding lateral: `clamp(2.5rem, 4vw, 5rem)` (= 58-77px).
- Display XL: 158-211px.
- Layout flex row.
- Wall: collage asimétrico, todas las cells visibles en 1 viewport.
- Header height: 68px.

### 7.5 Desktop 1920-2559

- Padding lateral: `clamp(2.5rem, 4vw, 5rem)` (= 77-102px máx clamped).
- Display XL: 211-281px (clamp se acerca al cap).
- Retrato hero: 580-620px ancho.
- Header height: 72px (cap).

### 7.6 Ultrawide 2560+

- Padding lateral: `5rem` (cap).
- Display XL: 224px (cap absoluto).
- Layout NO se centra con max-width — se distribuye edge-to-edge.
- Retrato hero: 620px (cap absoluto).
- En ultrawide, los gaps internos del hero (`gap` en el flex row) se aumentan con clamp:
```css
gap: clamp(2rem, 4vw, 4rem); /* hasta 64px en ultrawide */
```
- Esto evita el "mar central vacío" sin recurrir a max-width container (que rompería edge-to-edge).

### 7.7 Reglas escalables con clamp

Todo lo crítico usa `clamp(min, vw-based, max)`:
- Tipografía: ya cubierto en § 5.2.4.
- Padding lateral: `clamp(1.25rem, 4vw, 5rem)`.
- Padding vertical: `clamp(2.5rem, 5vw, 5rem)`.
- Gaps: `clamp(1rem, 2vw, 3rem)` o más generosos para hero.
- Frame bracket size: `clamp(20px, 2.4vw, 36px)`.
- Frame bracket offset: `clamp(8px, 1vw, 18px)`.
- Retrato width: `clamp(280px, 32vw, 620px)`.
- Cart drawer width: `min(440px, 90vw)`.

### 7.8 Touch targets mobile

En `@media (hover: none)`:
- Min target: `44 × 44px`.
- Padding aumenta para CTAs chicos.
- Hover effects desactivados (no se quedan stuck).

---

## 8. Contenido por página

> 5 páginas, cada una con sus secciones cerradas. **La home concentra 8 secciones (Opción C)**; las otras 4 vistas son simplificaciones temáticas.

### 8.1 Home `/` · `home.blade.php`

**Estructura cerrada de 8 secciones (Opción C)**:

```
[ HEADER FIXED ]
[ SECCIÓN 1 · HERO BLOCK-EMBER ]                — manifesto + retrato KITSUNE-01
[ SECCIÓN 2 · STATS GLOBALES BLOCK-INK ]        — franja con 4 números agregados (PROPIO CK)
[ SECCIÓN 3 · WALL ASIMÉTRICO BLOCK-INK ]       — collage de las 6 máscaras
[ SECCIÓN 4 · FEATURED MASK HERO BLOCK-INK ]    — máscara del día con kanji individual
[ SECCIÓN 5 · MAPA DE DISTRITOS BLOCK-INK ]     — grid 2×3 territorial (PROPIO CK)
[ SECCIÓN 6 · ÚLTIMA TRANSMISIÓN BLOCK-INK ]    — 1 destacada full-width (PROPIO CK)
[ SECCIÓN 7 · FEED 3 TRANSMISIONES BLOCK-INK ]  — feed simplificado
[ SECCIÓN 8 · CLOSING BLOCK-EMBER ]             — manifesto cierre + 2 CTAs
[ FOOTER COMPACTO ]
```

**🚫 NO**: secciones que el brief v2 incluía y v3 descarta:
- ❌ Manifesto Quote (era importada de Utopia)
- ❌ Kanji 狐 monumental + scrambled words (era patrón importado de Utopia, sin valor narrativo claro para CK)

#### 8.1.1 Sección 1 · Hero (block-ember)

**Layout**: edge-to-edge bg ember, flex row (lg+) o column (mobile).

**Top status bar** (dentro del hero, padding-top suficiente para no chocar con header fixed):
```
●  NODE · KITSUNE · 35.6762°N · 139.6503°E   [ INGRESO · 02:45 JST ]   V.26.05 · BUILD · 0xD4FF5B
```
Mono VT323 uppercase, color ink puro (no alpha), border-bottom 1px ink al 20%.

**Columna izquierda · manifesto**:
```
H1 (display-xl, ink, uppercase, 2 líneas):
  CIRCUITO
  KITSUNE

Tagline propia CK (display-md, ink, 3 líneas con dot ember al final):
  CADA NOCHE.
  UNA MÁSCARA.
  UN DISTRITO.

Body (Inter weight 500, ink, no uppercase para legibilidad):
  Tienda clandestina de máscaras del turno noche. Seis identidades,
  seis distritos, una señal por máscara. El circuito asigna; vos
  reservás antes de que cambie.

CTAs (bracket-cta variants):
  [ >_ ENTRAR AL ARCHIVO → ]   [ LEER TRANSMISIONES → ]
```

**Columna derecha · retrato dominante**:
- `<x-mask-portrait :product="$heroProduct" />` con la imagen WebP real (KITSUNE-01).
- Frame brackets gruesos color ink (`--bracket-color: var(--color-ink)`, `--bracket-size: clamp(20px, 2.4vw, 36px)`).
- Width: `clamp(280px, 32vw, 620px)`. Aspect-ratio: 3/4.
- Meta arriba (mono ink): `01 · 06   KITSUNE-01: ZORRO DE NEÓN`.
- Meta abajo (mono ink): `id · 0xKSN001   ·   signal · 87/99   ·   shibuya static`.

**Atmósfera del hero**:
- `scan-grid--ink` (líneas + dots negros sobre rojo, R9).
- Ambient letters scattered en bg `text-ink` puro: `k i t s u n` izquierda, `[loading] o b s e [loading]` derecha. Mono pequeño.
- Marquee inferior recursivo:
  ```
  · TURNO NOCHE ACTIVO · 06 IDENTIDADES · 04 DISPONIBLES · 35.6762°N · 139.6503°E · SEÑAL ABIERTA ·
  ```

**🚫 No** glow rojo extra (la sección ya es rojo full).
**🚫 No** retrato chico esquinero — retrato es protagonista.
**🚫 No** tagline traducida `MARCADO. ASIGNADO. DEVUELTO.` (era v2 sesgado a clone).

#### 8.1.2 Sección 2 · Stats globales del circuito (block-ink) · PROPIO CK

**Layout**: edge-to-edge bg ink, **min-height: auto** — es una franja compacta, no sección de viewport.

**Estructura**:

```
[ borde superior ash ]

▸ ESTADO DEL CIRCUITO · 35.6762°N · TURNO NOCHE

┌─ 06 ─────┐  ┌─ 04 ─────┐  ┌─ 11 ─────┐  ┌─ 05 ─────┐
│ IDENTI-  │  │ DISPONI- │  │ NOCHES   │  │ SEÑALES  │
│ DADES    │  │ BLES     │  │ ACTIVAS  │  │          │
└──────────┘  └──────────┘  └──────────┘  └──────────┘

[ borde inferior ash ]
```

**Detalles**:
- 4 stat-blocks horizontales en línea (mobile: grid 2×2).
- Cada stat: número grande en `display-lg` color **ember** (no bone), label mono uppercase color **bone-dim** debajo.
- Padding vertical: `clamp(2.5rem, 4vw, 4rem)`.
- Border-top: 1px solid ash. Border-bottom: 1px solid ash.
- Tag inicial top-left: `▸ ESTADO DEL CIRCUITO` system-tag con dot ember pulsante.
- **🚫 No** glow, **🚫 no** scan-grid en esta sección — es minimalista, da peso sin saturar.

**Datos** (cómputo desde el back):
- `06 IDENTIDADES` = `Product::count()`
- `04 DISPONIBLES` = `Product::available()->count()`
- `11 NOCHES ACTIVAS` = decorativo fijo (representa el "calendario ficcional" del circuito)
- `05 SEÑALES` = `Post::published()->count()`

**Justificación**: aporta peso institucional al sitio sin sumar otra sección de viewport. Es el equivalente "data-density" de un dashboard de operador. NO existe en Utopia, es propio CK.

#### 8.1.3 Sección 3 · Wall asimétrico (block-ink)

Ver R35 para grid layout cerrado.

**Estructura**:
```
[ ▸ ARCHIVO · 06 IDENTIDADES ACTIVAS ]
[ H2 display-lg: ARCHIVO DE MÁSCARAS. ]
[ body sm Inter: cada cuadro es un expediente. cada bracket rojo señala
  una identidad disponible esta noche. ]
[ HUD top-right: cluster: 06/06 · node: KSN-124 · ▸ click para abrir ]

[ COLLAGE ASIMÉTRICO de 6 cells, ver R35 ]:
  ┌─[KARASU-07]──┐  ┌──[KITSUNE-01]──┐  ┌─[ONI-09]─┐
  │  violet glow │  │   FEATURED      │  │ red glow  │
  │              │  │   brackets ember│  │           │
  └──────────────┘  │   + plus arriba │  └───────────┘
  ┌──[NEKO-03]──┐   │                 │
  │  gold glow  │   └─────────────────┘  ┌─[RONIN-X]─┐
  └─────────────┘   ┌─[SAKURA-404]┐      │ blue glow │
                    │ magenta glow│      │           │
                    └─────────────┘      └───────────┘

[ ▸ CTA: [ ARCHIVO COMPLETO → ] ]   [ HUD: "los 6 expedientes están sincronizados con el turno noche" ]
```

Cells del collage:
- Imagen WebP real del producto + glow del `dominant_color` (R10).
- Tag mono `[CODE]` arriba derecha (color bone-dim, ember si activa).
- Tag mono `[CODE] · [DISP/PROX/AGOT]` abajo (status corner mini).
- Hover: border-ember, translateY -3px, glow más intenso.
- Featured (KITSUNE-01): brackets ember externos `┌ ┐ └ ┘` + `+` arriba (R35).

**Click en cell** → `route('products.show', $product)`.

#### 8.1.4 Sección 4 · Featured Mask Hero (block-ink)

**Layout**: edge-to-edge bg ink, min-height 100dvh. Layout interno: kanji individual gigante de fondo + 2 columnas overlay (info izq + retrato der).

**Estructura**:
```
[ top status: ● DESTACADA · TURNO NOCHE · ID: 0xKSN001          04 / 08 — FEATURED ]

[ glow radial cyan (dominant_color de KITSUNE-01) detrás del retrato · 30% opacity ]

[ KANJI individual del producto, gigante centro ember 33% opacity:
  狐 (kitsune), 鬼 (oni), 烏 (karasu), 猫 (neko), 桜 (sakura), 浪 (ronin) ]

[ overlay grid 12-col encima del kanji:
  col-span 5 izq: H2 display-xl bone "KITSUNE-01"
                  / display-md ember "ZORRO DE NEÓN."
                  / body Inter bone-dim
                  / meta mono · CTA bracket
  col-span 7 der: <x-mask-portrait :product="$featured"> con frame brackets bone
                  / RGB-shift filter sutil (drop-shadow ember + bone) ]

[ 4 stat-blocks horizontales abajo ]
[ marquee bottom: "EXPEDIENTE DESTACADO · KSN-01 · DISTRITO SHIBUYA STATIC · RARA DE SEÑAL · $42.000" ]
```

**Detalles**:
- Kanji individual: usa el mapa `dominant_color → kanji` definido en R22.
- RGB-shift filter sobre el retrato: `filter: drop-shadow(-3px 0 var(--color-ember)) drop-shadow(3px 0 var(--color-bone));`. Aplica solo en hero featured (R-glitch).
- CTA principal: `[ >_ ABRIR EXPEDIENTE → ]` con variant ember.

#### 8.1.5 Sección 5 · Mapa de distritos (block-ink) · PROPIO CK

**Layout**: edge-to-edge bg ink, padding vertical generoso. Grid 2×3 (mobile 1×6).

**Estructura**:
```
[ ▸ TERRITORIOS · 06 DISTRITOS DEL CIRCUITO ]
[ H2 display-lg: MAPA DEL CIRCUITO. ]
[ body sm Inter: cada máscara opera en un distrito propio. la asignación
  cambia con la noche. ]

[ Grid 2×3 desktop, 1×6 mobile ]:
  ┌─ DISTRITO 01 ────────────┐  ┌─ DISTRITO 02 ────────────┐
  │ 35.6580°N · 139.7016°E   │  │ 35.6939°N · 139.7038°E   │
  │                          │  │                          │
  │ SHIBUYA STATIC           │  │ AKAI GATE                │
  │                          │  │                          │
  │ KITSUNE-01 · ACTIVO ●    │  │ ONI-09 · ACTIVO ●        │
  │ ┌ glow cyan sutil ┐      │  │ ┌ glow red sutil ┐       │
  └──────────────────────────┘  └──────────────────────────┘
  ┌─ DISTRITO 03 ────────────┐  ┌─ DISTRITO 04 ────────────┐
  │ CROWLINE TOWERS · KRS-07 │  │ MANEKI ALLEY · NKO-03    │
  └──────────────────────────┘  └──────────────────────────┘
  ┌─ DISTRITO 05 ────────────┐  ┌─ DISTRITO 06 ────────────┐
  │ HANAMI GRID · SKR-404    │  │ LAST TRAIN LOOP · RNX-00 │
  └──────────────────────────┘  └──────────────────────────┘
```

**Cada cell del mapa**:
- Frame brackets bone (`--bracket-color: var(--color-bone)`).
- Top: `▸ DISTRITO 0N` mono uppercase + coords ficticias en el formato `XX.XXXX°N · XXX.XXXX°E`.
- Centro: nombre del distrito en `display-md` bone, uppercase.
- Bottom: `[CODE] · [STATUS]` con dot ember si activo, ash si cerrado.
- Glow del dominant_color del producto asociado, sutil (15% opacity).
- Hover: border-ember + glow intensifica + translate-y -3px.
- Click → `/productos/{slug}` del producto del distrito.

**Datos de distritos** (ya seedeados en `Product::district`):
- `Shibuya Static` (Kitsune-01, cyan)
- `Akai Gate` (Oni-09, red)
- `Crowline Towers` (Karasu-07, violet)
- `Maneki Alley` (Neko-03, gold)
- `Hanami Grid` (Sakura-404, magenta)
- `Last Train Loop` (Ronin-X, blue)

**Coordenadas ficticias** generadas a partir del slug (deterministas):
```php
$lat = 35.65 + (crc32($product->slug) % 10000) / 100000;
$lng = 139.70 + (crc32($product->slug) % 10000) / 100000;
```

**Justificación**: aporta dimensión territorial/geográfica al producto. Diferencia el wall (objeto-céntrico) del mapa (geo-céntrico). NO existe en Utopia.

#### 8.1.6 Sección 6 · Última transmisión destacada (block-ink) · PROPIO CK

**Layout**: edge-to-edge bg ink, padding vertical generoso. Bloque protagónico full-width (no es lista).

**Estructura**:
```
[ ▸ ÚLTIMA SEÑAL · INTERCEPTADA HACE 4 H ]

[ Layout 2 columnas desktop / 1 mobile ]:

  Columna izq (col-span 7):
    ┌─ Tag mono: [GUÍA · 4 MIN DE LECTURA] · HASH: 0xXXX · BLOCK: TX-XXX
    │
    │ H2 display-lg: CÓMO ELEGIR TU PRIMERA MÁSCARA.
    │
    │ p Inter body-lg bone-dim:
    │   excerpt completo (3-4 líneas)
    │
    │ Meta mono uppercase: ARCHIVO KITSUNE · 03/05/2026 · SEÑAL 87/99
    │
    │ CTA: [ >_ LEER COMPLETA → ]
    └

  Columna der (col-span 5):
    ┌ Bloque visual decorativo (frame brackets ember + scan-grid mini):
    │   Kanji 信 (señal) gigante en el centro · ember 25% opacity
    │   Crosshair `+` superior
    └
```

**Detalles**:
- La transmisión mostrada es `Post::published()->latest('published_at')->first()`.
- Glow ember sutil bottom de la sección (radial-gradient, opacity 0.15).
- Border-top + border-bottom 1px ash que separan de las secciones adyacentes.

**Justificación**: en lugar de mostrar 3 transmisiones chiquitas (feed estándar), CK destaca 1 sola con peso editorial. Refuerza la narrativa de "señal interceptada". NO existe en Utopia (que solo tiene wall + featured).

#### 8.1.7 Sección 7 · Feed 3 transmisiones (block-ink) · simplificado

**Layout**: 1 columna `max-width: 720px` centrada. Es feed estándar minimalista.

**Estructura**:
```
[ ▸ MÁS SEÑALES · 02 RESTANTES EN FEED ]
[ H2 display-md: OTRAS TRANSMISIONES. ]

[ Lista de 2 entradas ] (las restantes después de la última destacada en § 8.1.6):
  - kanji 弐 ember + tag mono [SISTEMA · 5 MIN] + título display-md bone
    + excerpt 1 línea + meta mono
  - kanji 参 ember + tag mono [NOVEDADES · 6 MIN] + título + excerpt + meta

[ CTA: [ >_ ARCHIVO COMPLETO DE TRANSMISIONES → ] ]
```

**Notas**:
- Fórmula: muestra `Post::published()->latest('published_at')->skip(1)->take(2)->get()` (skip(1) para no repetir la destacada de § 8.1.6).
- Si hay menos de 3 posts publicados, muestra todos los disponibles excepto la destacada.
- Sin frame brackets en cells del feed — son entradas tipográficas, no cells visuales.
- Border-bottom 1px ash entre entradas.

#### 8.1.8 Sección 8 · Closing (block-ember)

**Layout**: edge-to-edge bg ember, min-height 90vh, centro absoluto.

**Estructura**:
```
[ kanji 終 sutil top center ash ]

[ H2 display-xl ink uppercase, 3 líneas:
  ELEGÍ TU TURNO.
  ABRÍ TU SEÑAL.
  ENTRÁ AL CIRCUITO. ]

[ body sm Inter ink, max-w 60ch:
  La noche es la única jurisdicción. Cada máscara es una entrada.
  El carrito se abre en la próxima fase. ]

[ CTAs:
  [ >_ ABRIR EL ARCHIVO → ] [ LEER TRANSMISIONES → ] ]

[ marquee bottom recursivo:
  TURNO NOCHE · IDENTIDAD ASIGNADA · SEÑAL ABIERTA · CIRCUITO KITSUNE ACTIVO · 35.6762°N · 139.6503°E ]
```

**Detalles**:
- Tagline en H2 con retórica propia CK (3 imperativos voseo, no traducción de Utopia).
- 2 CTAs ink sobre ember.
- Marquee inferior con texto recursivo (sin traducir de Utopia).
- Glow ember bottom (50% opacity radial) sutil para anclar la sección.

#### 8.1.9 Footer compacto

3 columnas (Navegación / Coordenadas / Aviso del carrito) + bottom row con copyright + hash diario decorativo. Ver § 6.3 para spec.

### 8.2 `/productos` · `products/index.blade.php`

**Estructura simplificada del wall** del home § 8.1.4 + filtros.

```
[ Hero corto (50vh) block-ink ]
  [ ▸ ARCHIVO · 06 IDENTIDADES ]
  [ H1 display-lg: ARCHIVO DE MÁSCARAS. ]
  [ body sm: descripción ]

[ Filtros tabs underline ]:
  [ TODOS ] [ DISPONIBLES ] [ PRÓXIMAS ] [ AGOTADAS ] [ RARAS ] [ LEGENDARIAS ]

[ Wall asimétrico ] (mismo layout § 8.1.4 pero con todas las máscaras según filtro)

[ Si filtro deja 0 productos: empty state mono "▸ NINGÚN EXPEDIENTE COINCIDE · "
   + CTA [ VER TODOS → ] ]
```

Filtros funcionan vía query-param `?filter=disponibles`, sin JS, server-rendered.

### 8.3 `/productos/{slug}` · `products/show.blade.php`

**Estructura** (4 secciones):

#### 8.3.1 Hero color-driven (block-ink + glow del dominant_color)

```
[ ▸ EXPEDIENTE 0007 · DISPONIBLE · VIOLET·SIGNAL ]

[ H1 display-xl ember:
  KARASU-07 ]
[ display-md bone:
  SEÑAL NEGRA. ]

[ body bone-dim 1.4vw line-height 1.55:
  short_description ]

[ HUD: HASH · BLOCK · SIGNAL ▓▓▓▓░░░ · code · distrito · rareza · precio ]

[ CTA: [ >_ RESERVAR → ] (disabled si !isAvailable) ]
[ microcopy ink-soft: "el carrito se abre en la próxima fase del circuito." ]

[ glow radial dominant_color centro derecho · 50% opacidad ]
[ <x-mask-portrait> con frame-brackets bone · derecha del hero ]
```

#### 8.3.2 Atributos (block-ink)

```
[ ▸ 01 · ATRIBUTOS ]
[ H2 display-md: COMO SE COMPORTA EL CIRCUITO. ]

[ Grid 2x2 mobile / 4-col desktop de stat-blocks:
  ▸ SEÑAL    91/99
  ▸ AGILIDAD 82/99
  ▸ ESPÍRITU 61/99
  ▸ FEROCIDAD 57/99 ]

[ Cada stat con kanji decorativo a la izquierda en bone-dim opacity 0.3
   (信 señal, 速 agilidad, 魂 espíritu, 怒 ferocidad) ]
```

#### 8.3.3 Protocolo (block-ink, prosa)

```
[ ▸ 02 · PROTOCOLO ]

[ <article max-width 64ch>
   [ long_description partido en párrafos · Inter 500 line-height 1.7 ]
   [ Primer párrafo con drop cap ember 5em ]
  </article> ]

[ Meta footer mono: "última sync · {date} · coords {coords}" ]
```

#### 8.3.4 Acción (block-ember)

```
[ H2 display-lg ink:
  RESERVÁ ESTA MÁSCARA. ]

[ body ink: estado del producto ]

[ CTA bracket prominent ink:
  [ >_ RESERVAR → ] (disabled si !isAvailable, opacity 0.4) ]

[ ink microcopy: "el carrito se abre en la próxima fase del circuito." ]

[ link: "← VOLVER AL ARCHIVO" ]
```

### 8.4 `/transmisiones` · `posts/index.blade.php`

**Estructura**: feed editorial 1 columna max-w 760px, similar a § 8.1.6 pero con TODAS las transmisiones (5).

```
[ Hero corto (50vh) block-ink ]
  [ ▸ FEED · 05 SEÑALES · EN LÍNEA ]
  [ H1 display-lg: TRANSMISIONES INTERCEPTADAS. ]
  [ body sm: descripción ]

[ Lista 5 entradas con kanji 壱 弐 参 肆 伍 + título + excerpt + meta ]
```

### 8.5 `/transmisiones/{slug}` · `posts/show.blade.php`

**Estructura** (artículo):

```
[ ▸ SEÑAL 001 · GUÍA · 4 MIN ]
[ H1 display-lg: COMO ELEGIR TU PRIMERA MÁSCARA. ]
[ Meta mono: AUTOR · FECHA · HASH ]

[ Pull quote: <blockquote border-left ember 3px padding 1.5rem>
   excerpt en display-sm bone-dim ]

[ <article max-w 720px>
   formattedBody() partido en párrafos · Inter 500 line-height 1.85
   Primer párrafo con drop cap ember 5em ]

[ Divider ]
[ Meta footer mono: "fin de la transmisión · " + hash final ]
[ CTA: [ ← VOLVER A TRANSMISIONES ] ]
```

---

## 9. Motion

### 9.1 Stack final

- **Lenis** (smooth scroll natural).
- **GSAP + ScrollTrigger** (free, sin SplitText premium).
- **Alpine.js** (state UI: cartOpen, filterActive).
- **CSS animations** para hover, transitions, marquee.

### 9.2 Reveals on scroll

```js
// data-reveal: opacidad + translateY 28px
// data-reveal-line: clip-path + translateY 110%
// data-reveal-delay: ms inline via style="--reveal-delay: 200ms"

if (!reducedMotion) {
    const obs = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });

    document.querySelectorAll('[data-reveal], [data-reveal-line]')
        .forEach((el) => obs.observe(el));
}
```

CSS:
```css
[data-reveal] {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 800ms var(--ease-cinema),
                transform 800ms var(--ease-cinema);
    transition-delay: var(--reveal-delay, 0ms);
}
[data-reveal].is-visible {
    opacity: 1;
    transform: translateY(0);
}
```

### 9.3 Scramble words (sección kanji)

JS scramble que reemplaza chars con random hasta el target, mientras incrementa `t` linealmente con scroll progress (ScrollTrigger scrub) o con timer (fallback IntersectionObserver).

### 9.4 Marquee animation

CSS pure, ver § 6.8.

### 9.5 Hover en bracket-cta

CSS: 380ms cinema, `background: currentColor` + `mix-blend-mode: difference` para que el texto invierta sobre el fill.

### 9.6 Reduced-motion fallback

Ver R50.

---

## 10. Accesibilidad WCAG AA

Ver § 4.7 (R69-R76) para reglas operativas. Resumen:

- Contraste verificado en § 5.1.2.
- Focus visible en todos interactivos (R73).
- Touch targets ≥ 44px (R74).
- Aria labels en botones sin texto (R75).
- Alt en imágenes (R76).
- Skip link (R72).
- Jerarquía heading correcta (R69-R70).
- HTML semántico (R71).
- Reduced motion (R50).

---

## 11. Performance targets

- **Lighthouse mobile**: perf ≥ 80, a11y ≥ 90, best-practices ≥ 90, SEO ≥ 90.
- **LCP** < 2.5s.
- **CLS** < 0.1.
- **TBT** < 200ms.
- **Bundle JS gzip** < 100 KB.
- **Bundle CSS gzip** < 80 KB.
- **Images**: WebP `loading="lazy" decoding="async" width height`.
- **Google Fonts**: `display=swap`.

---

## 12. Acceptance criteria

> Checklist verificable. **Cada item debe estar OK antes de declarar terminado el rediseño.**

### 12.1 Funcionales

- [ ] 5 rutas devuelven 200, ruta inválida → 404.
- [ ] Filtros del catálogo funcionan vía query-param sin JS (`/productos?filter=disponibles`).
- [ ] `php artisan migrate:fresh --seed` corre limpio.
- [ ] `npm run build` corre limpio.
- [ ] `npm run dev` corre con HMR.
- [ ] Mobile (375px), tablet (768px), desktop (1440px), ultrawide (2560px) sin bugs visibles.

### 12.2 Visuales

- [ ] Paleta limitada a 4 tokens (ink, ink-soft, bone, ember) + neutrales (bone-dim, ash, ink-deep) + glow producto.
- [ ] 4 familias tipográficas, no más, no menos.
- [ ] Layout edge-to-edge en color blocks.
- [ ] Padding interno fluido con clamp.
- [ ] Hero con scan-grid presente y visible.
- [ ] Wall asimétrico real (collage, no grid uniforme).
- [ ] Featured mask con kanji individual monumental.
- [ ] Frame brackets ASCII en CTAs y retratos.
- [ ] Marquee recursivo en mín 2 secciones del home.
- [ ] HUD details (status corner, hash, coords) presentes.

### 12.3 Tipografía

- [ ] H1 display-xl uppercase con letter-spacing -2%.
- [ ] Line-height ≤ 0.9 en display.
- [ ] Body Inter weight 500 con letter-spacing -0.5%.
- [ ] Mono VT323 uppercase tracking 8%.
- [ ] CJK Shippori Mincho B1 monumental (>30vw) en sección 3.
- [ ] **Sin ningún `font-style: italic`** en el sitio.

### 12.4 A11y

- [ ] 1 `<h1>` por página.
- [ ] Jerarquía h2 > h3 sin saltos.
- [ ] HTML semántico (header / nav / main / section / article / footer).
- [ ] Focus visible en todos interactivos (`outline: 2px solid ember; outline-offset: 4px`).
- [ ] Contraste texto/fondo ≥ 4.5:1 (verificar con axe DevTools).
- [ ] `prefers-reduced-motion` corta animaciones críticas.
- [ ] `aria-label` en botones sin texto.
- [ ] Skip link al main.
- [ ] Lighthouse a11y ≥ 90.
- [ ] Touch targets ≥ 44×44px en mobile.

### 12.5 Performance

- [ ] Lighthouse perf mobile ≥ 80.
- [ ] LCP < 2.5s.
- [ ] CLS < 0.1.
- [ ] CSS bundle gzip < 80 KB.
- [ ] JS bundle gzip < 100 KB.

### 12.6 Storytelling

- [ ] Home: **8 secciones definidas (Opción C)**, no más, no menos.
- [ ] Hero: tagline propia CK `CADA NOCHE. UNA MÁSCARA. UN DISTRITO.`, no traducción literal de Utopia.
- [ ] Stats globales: franja con 4 números agregados, border-y ash, propio CK.
- [ ] Wall: collage asimétrico real (R35), featured KITSUNE-01 con brackets ember + plus.
- [ ] Featured mask hero: kanji individual del producto + RGB-shift sutil.
- [ ] Mapa de distritos: grid 2×3 con los 6 distritos seedeados, glow del dominant_color, propio CK.
- [ ] Última transmisión: 1 bloque protagónico full-width, propio CK.
- [ ] Feed transmisiones: 2 entradas restantes (skip 1 = la destacada de § 8.1.6).
- [ ] Closing: block-ember invertido con manifesto propio CK + 2 CTAs.
- [ ] Detalle producto: bg ink + glow del dominant_color, no full saturación.
- [ ] Transmisiones: feed 1 columna max-w 760, no magazine asimétrico.
- [ ] **🚫 No** sección kanji 狐 monumental + scrambled words (descartada en v3).
- [ ] **🚫 No** sección manifesto quote "El circuito te lee" (descartada en v3).

---

## 13. Proceso de trabajo · cómo iterar

### 13.1 Cadencia obligatoria

1. **Una página por vez**. No tocar 2 páginas en paralelo.
2. **Una sección por vez** dentro de la página. Terminar sección + tomar screenshot + esperar OK del cliente antes de pasar a la siguiente.
3. **Borrar lo viejo antes de escribir lo nuevo**. No mezclar capas.
4. **Si el cliente dice "no me gusta"**, ANALIZAR la captura del cliente y comparar con la referencia ANTES de tocar más código. No hacer cambios "para ver si ahora sí".
5. **Si después de 2 correcciones el cliente sigue insatisfecho**, parar y preguntar.

### 13.2 Reglas de confirmación

- "Me gusta más" / "está mejor" → seguir iterando, NO terminado.
- "Está OK pasamos" / "dale terminala" / "siguiente página" → terminado, pasar.
- "Necesita cambios" → cambios concretos antes de seguir.
- "No te entiendo qué hiciste" → screenshot comparativo + explicación textual breve.

### 13.3 Verificación visual obligatoria por sección

Antes de declarar una sección terminada:

1. Screenshot a **1920×1080** (desktop standard).
2. Screenshot a **2560×1080** (ultrawide).
3. Screenshot a **1440×900** (laptop).
4. Screenshot a **390×844** (mobile).
5. Verificar contrastes con axe DevTools / WAVE.
6. Verificar que las animaciones se cortan con `prefers-reduced-motion: reduce`.
7. Confirmar que no hay scroll horizontal en mobile.

### 13.4 Cuando una decisión del brief no funciona

- **No improvisar**. Detenerse.
- Documentar el problema con screenshot + descripción.
- Proponer 2-3 opciones al cliente.
- Esperar decisión.
- **Actualizar el brief** (§ 14.4) con la decisión nueva antes de implementar.

### 13.5 Cuando el contexto se siente cargado

Después de ~25 turnos de conversación, **avisar al cliente** y proponer hacer un commit + push del estado y arrancar nueva sesión con el brief vigente. El brief debe ser autosuficiente para que la nueva sesión arranque con contexto fresco.

---

## 14. Anexos

### 14.1 Datos del DOM de Utopia (raw)

Ver `_research/utopia-styles.json` (no versionado, generado con `_research/inspect-utopia.mjs`).

### 14.2 Capturas de referencia

Conservadas localmente en:
- `tmp-screenshots/ref-utopia-*.png` (10 capturas desktop)
- `_research/ref-mobile-390-*.png` (4 capturas mobile)
- `_research/ref-tablet-768-*.png` (4 capturas tablet)
- `_research/ref-laptop-1024-*.png` (4 capturas laptop)

### 14.3 Glosario

- **Block** — `<section>` con bg edge-to-edge en uno de 2 modos (ink o ember).
- **Manifesto** — display brutalista uppercase como sección dominante (hero o closing).
- **HUD** — UI técnico (status corner, hash, coords, version, signal meter).
- **Marquee** — línea horizontal recursiva con texto en mono.
- **Bracket CTA** — botón con corner brackets ASCII (ver § 6.5).
- **Frame brackets** — marcas de esquina en retratos / cells (ver § 6.9).
- **Wall** — collage asimétrico de las 6 máscaras (ver § 8.1.3 + R35).
- **Featured** — la máscara protagonista del día (KITSUNE-01) con tratamiento ember + kanji individual.
- **Stats globales** — franja con 4 números agregados (§ 8.1.2), propio CK.
- **Mapa de distritos** — grid 2×3 territorial con los 6 distritos seedeados (§ 8.1.5), propio CK.
- **Última transmisión** — bloque protagónico full-width destacando la última señal publicada (§ 8.1.6), propio CK.
- **Scrambled** *(post-MVP)* — palabra con chars swap que se descifra en scroll. Descartado en Opción C como sección, queda como candidato (§ 14.5).
- **Eclipse circle** *(no aplica en CK)* — círculo del color del bg superpuesto al kanji monumental. Composición específica de Utopia, descartada en Opción C.

### 14.4 Registro de modificaciones al brief

| Fecha | Sección | Cambio | Motivo |
|---|---|---|---|
| 2026-05-05 | v2.0 inicial | Redacción completa post-reset | 5 iteraciones acumuladas + reset destructivo. Brief redactado tras reset desde 0. |
| 2026-05-05 | v3.0 (Opción C) | Reescritura de § 1.4 / § 2.4 / § 2.5 / § 3.8 / R22 / R59 / § 8.1 completo | Cliente identificó que el v2 estaba sesgado a clone literal de Utopia. v3 ratifica Opción C: tomar de Utopia el lenguaje visual (paleta, tipografía, densidad atmosférica), descartar el flow exacto del home + tagline traducida + frase scrambled + sección kanji monumental, agregar 3 secciones propias CK (stats globales § 8.1.2, mapa de distritos § 8.1.5, última transmisión destacada § 8.1.6). Imágenes WebP de las 6 máscaras subidas por el cliente y validadas (`hasImage()` = true para los 6 productos). |

### 14.5 Candidatos post-MVP

Ideas que aparecieron durante iteraciones previas pero NO entran en este brief. Documentadas para no perderlas, **NO IMPLEMENTAR sin aprobación explícita del cliente**:

- **Cursor custom dot+ring** con `mix-blend-mode: difference`. Solo si todas las páginas están terminadas y queda tiempo.
- **Boot loader micro-overture** (< 1s en primera visita con `sessionStorage` flag).
- **Glitch char-scramble** en hover de CTAs.
- **Frase scrambled words** estilo Utopia (`MASKZ → MASKS`) — descartado de v3, queda como candidato visual si el cliente quiere recuperarlo.
- **Hash random** que se actualiza cada hora (vs por día como está).
- **Ambient floating letters** en sección hero con física parallax (los chars `k i t s u n` reaccionan al mousemove).
- **Botón `[ SELECCIÓN ALEATORIA ]`** en hero con animación de selección dramática estilo Utopia.
- **Calendario de turnos** — qué máscara está activa en qué noche del mes (decorativo).
- **Test de identidad** — 3 preguntas con resultado pseudo-random que sugiere una máscara.
- **Filtro `?ordenar=` adicional** al `?filter=` actual del catálogo.
- **Compartir transmisión** con preview Twitter/OG meta tags.
- **RSS feed** de transmisiones.

---

## FIN DEL BRIEF

> Si llegaste hasta acá implementando, leíste 1300+ líneas de spec cerrada.
>
> Este doc no es orientativo. Cada regla absoluta tiene justificación real. Cada anti-pattern es una iteración fallida documentada. Cada valor numérico está cerrado.
>
> **Antes de implementar la primera línea de CSS o Blade, leé este doc completo. Cuando empieces a implementar, mantenelo abierto en otra ventana y consultá las secciones específicas.**
>
> **Si encontrás contradicción, ambigüedad o reglas que no cierran con la realidad, parar y actualizar el brief antes de seguir. El brief es la fuente de verdad.**
