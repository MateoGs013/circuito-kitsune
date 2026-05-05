import { chromium } from 'playwright';
import { mkdirSync } from 'fs';
import { resolve } from 'path';

const BASE = process.env.BASE_URL || 'http://127.0.0.1:8000';
const OUT = resolve(process.cwd(), 'tmp-screenshots/foundation');
mkdirSync(OUT, { recursive: true });

const viewports = [
    { name: '0390-mobile', width: 390, height: 844 },
    { name: '1440-laptop', width: 1440, height: 900 },
    { name: '1920-desktop', width: 1920, height: 1080 },
    { name: '2560-ultrawide', width: 2560, height: 1080 },
];

const pages = [
    { path: '/', label: 'home' },
    { path: '/productos', label: 'productos' },
    { path: '/transmisiones', label: 'transmisiones' },
];

const browser = await chromium.launch();
const ctx = await browser.newContext({ deviceScaleFactor: 1, reducedMotion: 'no-preference' });

for (const vp of viewports) {
    const page = await ctx.newPage();
    await page.setViewportSize({ width: vp.width, height: vp.height });

    for (const p of pages) {
        const url = BASE + p.path;
        await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
        await page.waitForTimeout(900); // dejar que fonts swap-in y reveal observer corra
        const file = `${OUT}/${vp.name}__${p.label}.png`;
        await page.screenshot({ path: file, fullPage: true });
        console.log('shot', vp.name, p.label);
    }

    await page.close();
}

await ctx.close();
await browser.close();
console.log('done →', OUT);
