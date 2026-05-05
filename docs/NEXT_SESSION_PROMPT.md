# Prompt — próxima sesión de Claude Code

> **Cómo usar**: copiá TODO lo que está debajo de `===PROMPT===` y pegalo como primer mensaje en una nueva sesión de Claude Code abierta en `C:\laragon\www\circuito-kitsune`.
>
> Antes de pegar, asegurate de:
> 1. Abrir Claude Code en una sesión NUEVA (cerrar la anterior).
> 2. Estar en el directorio del proyecto.
> 3. Tener PHP/Composer/Node en el PATH (si no, el prompt lo recuerda).

---

## ===PROMPT===

Hola. Vas a hacer el rediseño visual final de un proyecto Laravel 13 que ya tiene el back estable. **Antes de tocar nada**, leé estos 3 archivos en orden:

1. `docs/HANDOFF.md` — contexto operativo del proyecto (qué está estable, qué descartar, cómo iniciar).
2. `docs/DESIGN_BRIEF.md` — investigación + decisiones de diseño cerradas. Esta es la fuente de verdad. Si algo no está acá, default a "no hacerlo" o preguntame antes.
3. Este archivo (`docs/NEXT_SESSION_PROMPT.md`) — el flujo de trabajo.

**Lo que NO debés hacer**:
- No iterar acumulativamente sobre la capa visual actual. Está rota y hay que tirarla.
- No agregar atmospheric layers sumadas (vignette + scanlines + light-leak + grain + parallax kanji todo junto).
- No mezclar 4 colores de acento. Solo 1 (`--ember` en `DESIGN_BRIEF.md` § 2.1).
- No usar 10 estrategias tipográficas distintas. Solo 3 (§ 2.2).
- No prometer interactividad que no funciona. El carrito es visual, decirlo en copy.
- No agregar componentes que el brief no pide.

**Lo que SÍ debés hacer**:
1. Leer los 3 docs.
2. Resumime en 5-8 bullets qué entendiste del brief antes de tocar código.
3. Esperar mi confirmación.
4. Cuando confirme, hacer el cleanup (borrar capa visual rota — comandos en `HANDOFF.md` § 4).
5. Implementar siguiendo `DESIGN_BRIEF.md` paso a paso, página por página, con builds + screenshots de validación visual (Playwright headless está disponible si lo querés instalar de nuevo).
6. Al final de CADA página, mostrame screenshots y preguntame si seguimos. NO hagas las 5 vistas de corrido.

**Stack a instalar al inicio**:
```bash
npm install lenis gsap
# alpinejs ya está
```

**Comandos para correr el proyecto** (desde `C:\laragon\www\circuito-kitsune`):
```powershell
$env:PATH = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64;C:\laragon\bin\composer;" + $env:PATH
composer install
npm install
php artisan migrate:fresh --seed
npm run dev          # terminal 1
php artisan serve    # terminal 2
```

**Reglas de proceso** (para no caer en los errores de la sesión anterior):
- **Una página completa antes de pasar a la siguiente**. No tocar todas las views en paralelo.
- **Después de cada página, screenshot + check + STOP**. No iterar 5 cambios sin que yo los vea.
- **Si el contexto se siente cargado** (después de ~25 turnos), avisame y armamos otro handoff antes de seguir.
- **Si una decisión del brief se siente ambigua**, preguntá antes de improvisar.
- **Borrar lo viejo antes de escribir lo nuevo**. No acumular clases CSS encima de las anteriores.

**Constraints académicas** (no negociables, ya cumplidas en back, mantenerlas en front):
- Laravel 13 ✓ MVC ✓ Blade ✓ Tailwind ✓
- 1 `<h1>` por página
- HTML semántico
- Mobile-first responsive
- `prefers-reduced-motion` respetado
- Sin imágenes remotas
- Sin lógica en `routes/web.php`
- Carrito contemplado visualmente, no funcional

**Acceptance criteria** completo en `DESIGN_BRIEF.md` § 5.

---

Empezá leyendo los 3 archivos. Hablamos cuando termines.

## ===FIN PROMPT===

---

## Notas para vos (mateo) sobre cómo tratar a Claude en la próxima sesión

1. **Si Claude dice "voy a hacer X" sin haber leído los docs, frenalo**. Decile: "primero leé los 3 archivos en `docs/`".

2. **Si Claude empieza a iterar sin parar y sumar features**, decile: "stop. revisemos el brief. ¿qué dice § X?".

3. **Si Claude no pregunta antes de improvisar**, decile: "el brief no cubre eso. ¿preguntaste o asumiste?". El brief deliberadamente NO cubre todo — algunas decisiones quedan para hablar.

4. **Si Claude dice "lo arreglo todo de una"**, decile: "una página a la vez. screenshot + check antes de seguir". Eso fue lo que faltó en la sesión anterior.

5. **Si después de 20-25 turnos la cosa se siente saturada**, pedile que escriba un nuevo handoff y arrancá otra sesión. No insistas con la misma sesión.

6. **Para revisión visual**: pedile a Claude que tome screenshots con Playwright (es gratis, lo puede instalar) y los lea él mismo antes de mostrarte. Que vea lo que hizo, no que confíe en lo que escribió.

7. **Si el rediseño falla otra vez**, las 3 cosas a verificar son:
   - ¿Tiraste la capa visual vieja antes de empezar? (sin esto, todo lo nuevo se contamina con lo viejo)
   - ¿Está siguiendo el brief o improvisando? (pedile que cite el brief al tomar decisiones)
   - ¿Una página a la vez con check visual? (si está haciendo todo de una sin mostrarte, frenalo)
