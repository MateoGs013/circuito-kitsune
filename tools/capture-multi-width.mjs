// Capturas en múltiples anchos · 1440 / 1920 / 2560 / 3440 ultrawide
import { chromium } from 'playwright';

const url = 'http://127.0.0.1:8000/';
const browser = await chromium.launch();

const widths = [
    { w: 1440, h: 900,  name: 'desktop-1440' },
    { w: 1920, h: 1080, name: 'desktop-1920' },
    { w: 2560, h: 1080, name: 'ultrawide-2560' },
    { w: 3440, h: 1440, name: 'ultrawide-3440' },
];

for (const { w, h, name } of widths) {
    const ctx = await browser.newContext({
        viewport: { width: w, height: h },
        deviceScaleFactor: 1,
    });
    const page = await ctx.newPage();
    await page.addInitScript(() => {
        try { sessionStorage.setItem('ck-booted', '1'); } catch (e) {}
    });
    await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(1100);
    await page.screenshot({ path: `tmp-screenshots/hero-${name}.png` });
    console.log(`✓ hero-${name}.png (${w}×${h})`);

    // wall section
    await page.evaluate(() => {
        const wall = document.querySelector('[aria-labelledby="wall-heading"]');
        if (wall) wall.scrollIntoView({ block: 'start', behavior: 'instant' });
    });
    await page.waitForTimeout(700);
    await page.screenshot({ path: `tmp-screenshots/wall-${name}.png` });
    console.log(`✓ wall-${name}.png (${w}×${h})`);

    await ctx.close();
}

await browser.close();
console.log('Done.');
