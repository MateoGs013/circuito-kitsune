// Captura múltiples screenshots de la home iteración 5
import { chromium } from 'playwright';

const url = process.argv[2] || 'http://127.0.0.1:8000/';
const browser = await chromium.launch();

// ─── Desktop full reduced
{
    const ctx = await browser.newContext({
        viewport: { width: 1440, height: 900 },
        deviceScaleFactor: 1,
        reducedMotion: 'reduce',
    });
    const page = await ctx.newPage();
    await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(800);
    await page.screenshot({ path: 'tmp-screenshots/01a-home-desktop-reduced.png', fullPage: true });
    console.log('✓ 01a-home-desktop-reduced.png');
    await ctx.close();
}

// ─── Desktop por viewport (motion normal, post-boot)
{
    const ctx = await browser.newContext({
        viewport: { width: 1440, height: 900 },
        deviceScaleFactor: 1,
    });
    const page = await ctx.newPage();
    await page.addInitScript(() => {
        try { sessionStorage.setItem('ck-booted', '1'); } catch (e) {}
    });
    await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(1400);

    await page.screenshot({ path: 'tmp-screenshots/01b-hero.png' });
    console.log('✓ 01b-hero.png');

    await page.evaluate(() => window.scrollTo({ top: window.innerHeight, behavior: 'instant' }));
    await page.waitForTimeout(400);
    await page.screenshot({ path: 'tmp-screenshots/01c-quote.png' });
    console.log('✓ 01c-quote.png');

    // sección kanji 狐 monumental
    await page.evaluate(() => window.scrollTo({ top: window.innerHeight * 1.6, behavior: 'instant' }));
    await page.waitForTimeout(900);
    await page.screenshot({ path: 'tmp-screenshots/01d-kanji-monumental.png' });
    console.log('✓ 01d-kanji-monumental.png');

    // sección WALL of identities
    await page.evaluate(() => {
        const wall = document.querySelector('[aria-labelledby="wall-heading"]');
        if (wall) wall.scrollIntoView({ block: 'start', behavior: 'instant' });
    });
    await page.waitForTimeout(700);
    await page.screenshot({ path: 'tmp-screenshots/01e-wall-of-identities.png' });
    console.log('✓ 01e-wall-of-identities.png');

    // wall completo (desplazar un poco hacia abajo)
    await page.evaluate(() => window.scrollBy({ top: window.innerHeight * 0.5, behavior: 'instant' }));
    await page.waitForTimeout(500);
    await page.screenshot({ path: 'tmp-screenshots/01e2-wall-bottom.png' });
    console.log('✓ 01e2-wall-bottom.png');

    // featured mask hero
    await page.evaluate(() => {
        const f = document.querySelector('[aria-labelledby="featured-heading"]');
        if (f) f.scrollIntoView({ block: 'start', behavior: 'instant' });
    });
    await page.waitForTimeout(700);
    await page.screenshot({ path: 'tmp-screenshots/01f-featured-mask.png' });
    console.log('✓ 01f-featured-mask.png');

    // feed de transmisiones
    await page.evaluate(() => {
        const feed = document.querySelector('[aria-labelledby="feed-heading"]');
        if (feed) feed.scrollIntoView({ block: 'start', behavior: 'instant' });
    });
    await page.waitForTimeout(700);
    await page.screenshot({ path: 'tmp-screenshots/01g-feed.png' });
    console.log('✓ 01g-feed.png');

    // closing
    await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
    await page.waitForTimeout(700);
    await page.screenshot({ path: 'tmp-screenshots/01h-closing-footer.png' });
    console.log('✓ 01h-closing-footer.png');

    await ctx.close();
}

// ─── Mobile 375
{
    const ctx = await browser.newContext({
        viewport: { width: 375, height: 812 },
        deviceScaleFactor: 2,
        reducedMotion: 'reduce',
    });
    const page = await ctx.newPage();
    await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(800);
    await page.screenshot({ path: 'tmp-screenshots/01i-home-mobile.png', fullPage: true });
    console.log('✓ 01i-home-mobile.png');
    await ctx.close();
}

await browser.close();
console.log('Done.');
