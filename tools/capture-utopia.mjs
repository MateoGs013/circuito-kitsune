// Capturas de referencia · utopiatokyo.com (entrando al sitio real)
import { chromium } from 'playwright';

const browser = await chromium.launch();
const ctx = await browser.newContext({
    viewport: { width: 1440, height: 900 },
    deviceScaleFactor: 1,
});
const page = await ctx.newPage();

await page.goto('https://www.utopiatokyo.com/', { waitUntil: 'networkidle', timeout: 60000 });
await page.waitForTimeout(2000);

// ─── 0. modal warning
await page.screenshot({ path: 'tmp-screenshots/ref-utopia-00-warning.png' });
console.log('✓ ref-utopia-00-warning.png (warning modal)');

// click "ENABLE GLITCH EFFECT"
try {
    await page.getByText(/ENABLE GLITCH EFFECT/i).click({ timeout: 5000 });
    console.log('  clicked: ENABLE GLITCH EFFECT');
} catch (e) {
    try {
        await page.locator('text=/ENABLE.*GLITCH/i').first().click({ timeout: 5000 });
        console.log('  fallback clicked');
    } catch (err) {
        console.log('  could not click — trying USE SAFE MODE');
        try { await page.getByText(/USE SAFE MODE/i).click(); } catch (e2) {}
    }
}
await page.waitForTimeout(3500); // dejar que el sitio cargue post-modal

// ─── 1. hero post-modal
await page.evaluate(() => window.scrollTo(0, 0));
await page.waitForTimeout(1500);
await page.screenshot({ path: 'tmp-screenshots/ref-utopia-01-hero.png' });
console.log('✓ ref-utopia-01-hero.png');

// scrolls
for (let i = 1; i <= 6; i++) {
    await page.evaluate((m) => window.scrollTo({ top: window.innerHeight * m, behavior: 'instant' }), i * 1.1);
    await page.waitForTimeout(1300);
    await page.screenshot({ path: `tmp-screenshots/ref-utopia-0${i + 1}.png` });
    console.log(`✓ ref-utopia-0${i + 1}.png (scroll ${i * 1.1}vh)`);
}

// final scroll
await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
await page.waitForTimeout(1500);
await page.screenshot({ path: 'tmp-screenshots/ref-utopia-08-bottom.png' });
console.log('✓ ref-utopia-08-bottom.png');

await browser.close();
console.log('Done.');
