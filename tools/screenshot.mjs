// Screenshot helper · Playwright headless
// Uso: node tools/screenshot.mjs <url> <output> [width] [height]
import { chromium } from 'playwright';

const [, , url, output, w = '1440', h = '900'] = process.argv;
if (!url || !output) {
    console.error('uso: node tools/screenshot.mjs <url> <output.png> [width] [height]');
    process.exit(1);
}

const browser = await chromium.launch();
const ctx = await browser.newContext({
    viewport: { width: parseInt(w, 10), height: parseInt(h, 10) },
    deviceScaleFactor: 1,
    reducedMotion: 'no-preference',
});
const page = await ctx.newPage();
await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
await page.waitForTimeout(800); // dejar que reveals corran
await page.screenshot({ path: output, fullPage: true });
await browser.close();
console.log(`✓ ${output}`);
