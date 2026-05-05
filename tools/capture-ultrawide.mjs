// Capturas a tamaño ultrawide para reproducir el bug del usuario
import { chromium } from 'playwright';

const url = 'http://127.0.0.1:8000/';
const browser = await chromium.launch();

// 1920×1080 estándar
{
    const ctx = await browser.newContext({
        viewport: { width: 1920, height: 1080 },
        deviceScaleFactor: 1,
    });
    const page = await ctx.newPage();
    await page.addInitScript(() => {
        try { sessionStorage.setItem('ck-booted', '1'); } catch (e) {}
    });
    await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(1200);
    await page.screenshot({ path: 'tmp-screenshots/ultra-01-hero-1920.png' });
    console.log('✓ ultra-01-hero-1920.png');

    await page.evaluate(() => {
        const wall = document.querySelector('[aria-labelledby="wall-heading"]');
        if (wall) wall.scrollIntoView({ block: 'start', behavior: 'instant' });
    });
    await page.waitForTimeout(700);
    await page.screenshot({ path: 'tmp-screenshots/ultra-02-wall-1920.png' });
    console.log('✓ ultra-02-wall-1920.png');

    await ctx.close();
}

// 2560×1080 ultrawide
{
    const ctx = await browser.newContext({
        viewport: { width: 2560, height: 1080 },
        deviceScaleFactor: 1,
    });
    const page = await ctx.newPage();
    await page.addInitScript(() => {
        try { sessionStorage.setItem('ck-booted', '1'); } catch (e) {}
    });
    await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(1200);
    await page.screenshot({ path: 'tmp-screenshots/ultra-03-hero-2560.png' });
    console.log('✓ ultra-03-hero-2560.png');

    await page.evaluate(() => {
        const wall = document.querySelector('[aria-labelledby="wall-heading"]');
        if (wall) wall.scrollIntoView({ block: 'start', behavior: 'instant' });
    });
    await page.waitForTimeout(700);
    await page.screenshot({ path: 'tmp-screenshots/ultra-04-wall-2560.png' });
    console.log('✓ ultra-04-wall-2560.png');

    await ctx.close();
}

await browser.close();
console.log('Done.');
