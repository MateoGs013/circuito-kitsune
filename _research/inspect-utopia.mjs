// Inspecciona utopiatokyo.com extrayendo getComputedStyle real del DOM
// Output: _research/utopia-styles.json + capturas adicionales
import { chromium } from 'playwright';
import { writeFileSync } from 'fs';

const browser = await chromium.launch();

// ─── 1. Extraer estilos reales del DOM en desktop
const ctx = await browser.newContext({
    viewport: { width: 1920, height: 1080 },
    deviceScaleFactor: 1,
});
const page = await ctx.newPage();
await page.goto('https://www.utopiatokyo.com/', { waitUntil: 'networkidle', timeout: 60000 });
await page.waitForTimeout(2000);

// click ENABLE GLITCH para entrar
try { await page.getByText(/ENABLE GLITCH EFFECT/i).click({ timeout: 5000 }); } catch (e) {}
await page.waitForTimeout(3500);

// extraer estilos de elementos clave
const styles = await page.evaluate(() => {
    const inspectFor = {};

    // body
    const body = document.body;
    const bodyStyle = getComputedStyle(body);
    inspectFor.body = {
        fontFamily: bodyStyle.fontFamily,
        fontSize: bodyStyle.fontSize,
        color: bodyStyle.color,
        backgroundColor: bodyStyle.backgroundColor,
        lineHeight: bodyStyle.lineHeight,
    };

    // todos los headings
    inspectFor.headings = [];
    document.querySelectorAll('h1, h2, h3').forEach((h, i) => {
        if (i > 8) return;
        const s = getComputedStyle(h);
        inspectFor.headings.push({
            tag: h.tagName,
            text: h.textContent.trim().substring(0, 60),
            fontFamily: s.fontFamily,
            fontSize: s.fontSize,
            fontWeight: s.fontWeight,
            lineHeight: s.lineHeight,
            letterSpacing: s.letterSpacing,
            textTransform: s.textTransform,
            color: s.color,
        });
    });

    // párrafos / body text
    inspectFor.paragraphs = [];
    document.querySelectorAll('p').forEach((p, i) => {
        if (i > 5) return;
        const s = getComputedStyle(p);
        inspectFor.paragraphs.push({
            text: p.textContent.trim().substring(0, 80),
            fontFamily: s.fontFamily,
            fontSize: s.fontSize,
            fontWeight: s.fontWeight,
            lineHeight: s.lineHeight,
            letterSpacing: s.letterSpacing,
            color: s.color,
        });
    });

    // links / botones
    inspectFor.interactive = [];
    document.querySelectorAll('a, button').forEach((el, i) => {
        if (i > 8) return;
        const s = getComputedStyle(el);
        inspectFor.interactive.push({
            tag: el.tagName,
            text: el.textContent.trim().substring(0, 50),
            fontFamily: s.fontFamily,
            fontSize: s.fontSize,
            fontWeight: s.fontWeight,
            color: s.color,
            backgroundColor: s.backgroundColor,
            border: s.border,
            padding: s.padding,
            textTransform: s.textTransform,
            letterSpacing: s.letterSpacing,
        });
    });

    // colores únicos en uso (top 20)
    const colorMap = new Map();
    document.querySelectorAll('*').forEach((el) => {
        const s = getComputedStyle(el);
        [s.color, s.backgroundColor, s.borderColor].forEach((c) => {
            if (!c || c === 'rgba(0, 0, 0, 0)' || c === 'transparent') return;
            colorMap.set(c, (colorMap.get(c) || 0) + 1);
        });
    });
    inspectFor.topColors = [...colorMap.entries()]
        .sort((a, b) => b[1] - a[1])
        .slice(0, 25)
        .map(([color, count]) => ({ color, count }));

    // font families únicas
    const fontMap = new Map();
    document.querySelectorAll('*').forEach((el) => {
        const f = getComputedStyle(el).fontFamily;
        if (f) fontMap.set(f, (fontMap.get(f) || 0) + 1);
    });
    inspectFor.topFonts = [...fontMap.entries()]
        .sort((a, b) => b[1] - a[1])
        .slice(0, 15)
        .map(([font, count]) => ({ font, count }));

    // viewport y stylesheets
    inspectFor.viewport = {
        width: window.innerWidth,
        height: window.innerHeight,
        dpr: window.devicePixelRatio,
    };

    inspectFor.stylesheets = [...document.styleSheets]
        .map(s => {
            try { return s.href || '(inline)'; } catch (e) { return '(blocked)'; }
        });

    // tipografía a tamaño real (en px) de headings notables
    inspectFor.h1MainStyles = (() => {
        const candidates = [...document.querySelectorAll('h1, h2, [class*="hero"], [class*="title"], [class*="heading"]')];
        return candidates.slice(0, 12).map(el => {
            const s = getComputedStyle(el);
            const cn = (typeof el.className === 'string') ? el.className : (el.getAttribute('class') || '');
            return {
                selector: el.tagName + (cn ? '.' + cn.split(' ').slice(0, 2).join('.') : ''),
                text: el.textContent.trim().substring(0, 50),
                fontFamily: s.fontFamily,
                fontSize: s.fontSize,
                fontWeight: s.fontWeight,
                fontStretch: s.fontStretch,
                color: s.color,
            };
        });
    })();

    return inspectFor;
});

writeFileSync('_research/utopia-styles.json', JSON.stringify(styles, null, 2));
console.log('✓ utopia-styles.json');

// ─── 2. capturas adicionales · mobile + tablet
const profiles = [
    { w: 390,  h: 844,  name: 'mobile-390' },
    { w: 768,  h: 1024, name: 'tablet-768' },
    { w: 1024, h: 768,  name: 'laptop-1024' },
];

for (const p of profiles) {
    const c = await browser.newContext({
        viewport: { width: p.w, height: p.h },
        deviceScaleFactor: 1,
    });
    const pg = await c.newPage();
    await pg.goto('https://www.utopiatokyo.com/', { waitUntil: 'networkidle', timeout: 60000 });
    await pg.waitForTimeout(2500);
    try { await pg.getByText(/ENABLE GLITCH EFFECT/i).click({ timeout: 4000 }); } catch (e) {}
    await pg.waitForTimeout(2500);

    // capturar 4 puntos del scroll
    for (let i = 0; i < 4; i++) {
        await pg.evaluate((m) => window.scrollTo({ top: window.innerHeight * m, behavior: 'instant' }), i * 1.2);
        await pg.waitForTimeout(900);
        await pg.screenshot({ path: `_research/ref-${p.name}-${i}.png` });
        console.log(`✓ ref-${p.name}-${i}.png`);
    }

    await c.close();
}

await browser.close();
console.log('Done.');
