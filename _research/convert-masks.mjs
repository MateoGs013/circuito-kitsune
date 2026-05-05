// Convierte PNG → WebP + renombra a slug · cleanup PNG después
import sharp from 'sharp';
import { readdirSync, unlinkSync } from 'fs';
import { join } from 'path';

const dir = 'public/images/products';

// orden de las imágenes según identificación visual del cliente
const map = [
    { from: 'ChatGPT Image May 5, 2026, 12_00_40 AM (1) - Editado.png', to: 'kitsune-01-zorro-de-neon.webp' },
    { from: 'ChatGPT Image May 5, 2026, 12_00_40 AM (2) - Editado.png', to: 'oni-09-protocolo-rojo.webp' },
    { from: 'ChatGPT Image May 5, 2026, 12_00_40 AM (3) - Editado.png', to: 'karasu-07-senal-negra.webp' },
    { from: 'ChatGPT Image May 5, 2026, 12_00_40 AM (4) - Editado.png', to: 'neko-03-glitch-de-la-suerte.webp' },
    { from: 'ChatGPT Image May 5, 2026, 12_00_40 AM (5) - Editado.png', to: 'sakura-404-flor-rota.webp' },
    { from: 'ChatGPT Image May 5, 2026, 12_00_40 AM (6) - Editado.png', to: 'ronin-x-ultimo-pasajero.webp' },
];

for (const { from, to } of map) {
    const src = join(dir, from);
    const dst = join(dir, to);
    const result = await sharp(src)
        .webp({ quality: 88, effort: 6 })
        .toFile(dst);
    console.log(`✓ ${to.padEnd(40)} → ${(result.size / 1024).toFixed(0)} KB`);
}

// borrar PNGs originales
for (const { from } of map) {
    unlinkSync(join(dir, from));
    console.log(`× delete: ${from}`);
}

console.log('\nDone.');
