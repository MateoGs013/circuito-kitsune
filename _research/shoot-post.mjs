import { chromium } from 'playwright';
import { mkdirSync } from 'fs';
import { resolve } from 'path';

const BASE = 'http://127.0.0.1:8000';
const OUT = resolve(process.cwd(), 'tmp-screenshots/full');
mkdirSync(OUT, { recursive: true });

const viewports = [
    { name: '0390-mobile', width: 390, height: 844 },
    { name: '1440-laptop', width: 1440, height: 900 },
    { name: '1920-desktop', width: 1920, height: 1080 },
    { name: '2560-ultrawide', width: 2560, height: 1080 },
];

const browser = await chromium.launch();

for (const vp of viewports) {
    const ctx = await browser.newContext({
        viewport: { width: vp.width, height: vp.height },
        deviceScaleFactor: 1,
    });
    const page = await ctx.newPage();
    await page.goto(BASE + '/transmisiones/como-elegir-tu-primera-mascara', { waitUntil: 'networkidle' });
    await page.waitForTimeout(900);
    await page.evaluate(() => {
        document.querySelectorAll('[data-reveal]').forEach(el => el.classList.add('is-visible'));
    });
    await page.screenshot({ path: `${OUT}/${vp.name}__06-post-detail.png`, fullPage: true });
    console.log('shot', vp.name);
    await ctx.close();
}
await browser.close();
