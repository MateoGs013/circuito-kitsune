import { chromium } from 'playwright';
import { mkdirSync } from 'fs';
import { resolve } from 'path';

const BASE = process.env.BASE_URL || 'http://127.0.0.1:8000';
const OUT = resolve(process.cwd(), 'tmp-screenshots/full');
mkdirSync(OUT, { recursive: true });

const viewports = [
    { name: '0390-mobile', width: 390, height: 844 },
    { name: '1440-laptop', width: 1440, height: 900 },
    { name: '1920-desktop', width: 1920, height: 1080 },
    { name: '2560-ultrawide', width: 2560, height: 1080 },
];

const pages = [
    { path: '/', label: '01-home' },
    { path: '/productos', label: '02-productos' },
    { path: '/productos/kitsune-01-zorro-de-neon', label: '03-product-kitsune' },
    { path: '/productos/oni-09-protocolo-rojo', label: '04-product-oni' },
    { path: '/transmisiones', label: '05-transmisiones' },
];

const browser = await chromium.launch();

for (const vp of viewports) {
    const ctx = await browser.newContext({
        viewport: { width: vp.width, height: vp.height },
        deviceScaleFactor: 1,
        reducedMotion: 'no-preference',
    });
    const page = await ctx.newPage();

    for (const p of pages) {
        try {
            await page.goto(BASE + p.path, { waitUntil: 'networkidle', timeout: 30000 });
            await page.waitForTimeout(1000);
            await page.evaluate(() => {
                document.querySelectorAll('[data-reveal], [data-reveal-line]')
                    .forEach(el => el.classList.add('is-visible'));
            });
            await page.waitForTimeout(300);

            const file = `${OUT}/${vp.name}__${p.label}.png`;
            await page.screenshot({ path: file, fullPage: true });
            console.log('shot', vp.name, p.label);
        } catch (e) {
            console.log('FAIL', vp.name, p.label, e.message);
        }
    }

    await ctx.close();
}

// captura una primera transmisión también
const lastCtx = await browser.newContext({
    viewport: { width: 1920, height: 1080 },
    deviceScaleFactor: 1,
});
const lastPage = await lastCtx.newPage();
try {
    await lastPage.goto(BASE + '/transmisiones', { waitUntil: 'networkidle' });
    const firstLink = await lastPage.getAttribute('a[href*="/transmisiones/"]:not([href$="transmisiones"])', 'href');
    if (firstLink) {
        await lastPage.goto(BASE + firstLink, { waitUntil: 'networkidle' });
        await lastPage.waitForTimeout(900);
        await lastPage.evaluate(() => {
            document.querySelectorAll('[data-reveal]').forEach(el => el.classList.add('is-visible'));
        });
        await lastPage.screenshot({ path: `${OUT}/1920-desktop__06-post-detail.png`, fullPage: true });
        console.log('shot 1920-desktop 06-post-detail');
    }
} catch (e) {
    console.log('FAIL post-detail', e.message);
}
await lastCtx.close();

// 404 check
const errCtx = await browser.newContext({ viewport: { width: 1440, height: 900 } });
const errPage = await errCtx.newPage();
try {
    const resp = await errPage.goto(BASE + '/no-existe', { waitUntil: 'networkidle' });
    console.log('404 status:', resp ? resp.status() : 'no response');
} catch (e) {
    console.log('404 err:', e.message);
}
await errCtx.close();

await browser.close();
console.log('done →', OUT);
