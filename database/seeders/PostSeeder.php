<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Cómo elegir tu primera máscara',
                'slug' => 'como-elegir-tu-primera-mascara',
                'excerpt' => 'Una introducción para nuevos usuarios del circuito: rareza, distrito, señal y tipo de identidad.',
                'body' => "Elegir la primera máscara del Circuito no es una decisión decorativa. Cada identidad define por qué distritos vas a poder moverte, a qué horas y con qué nivel de exposición. Antes de comprar, conviene tener claro qué tipo de noche estás buscando.\n\nLa rareza condiciona el comportamiento del lector. Las identidades comunes responden rápido y se renuevan fácil. Las raras y prohibidas, en cambio, tardan más en validar y suelen requerir distritos específicos. No siempre conviene empezar por la más alta.\n\nLa señal es la otra variable importante. Una máscara de señal alta atraviesa zonas saturadas sin perder lectura, pero también deja huella. Para una primera salida, una señal media y un distrito de tránsito libre es la combinación más amable.\n\nNo hay máscara universal. Hay máscara para vos, para esta semana, para esta ciudad.",
                'category' => 'Guía',
                'author' => 'Archivo Kitsune',
                'published_at' => now()->subDays(2),
                'reading_time' => 4,
                'cover_tone' => 'cyan',
                'is_featured' => true,
            ],
            [
                'title' => 'Qué significa la rareza dentro del circuito',
                'slug' => 'que-significa-la-rareza-dentro-del-circuito',
                'excerpt' => 'No todas las máscaras abren las mismas puertas. La rareza define comportamiento, acceso y estabilidad.',
                'body' => "Dentro del Circuito Kitsune, la rareza no es un sello de prestigio: es una etiqueta de funcionamiento. Una máscara común se comporta de forma estable, valida en cualquier lector estándar y rara vez genera reportes.\n\nLas máscaras raras agregan capas de lectura. Pueden abrir distritos limitados, pero también requieren calibración periódica. Las prohibidas, las sombras y las inestables tienen comportamiento alterado por diseño: no se rompen, pero tampoco siguen las reglas comunes.\n\nLas legendarias y fantasma son otra categoría. No están pensadas para uso diario. Aparecen en momentos puntuales del circuito y desaparecen por temporadas enteras. Conviene tratarlas como herramientas específicas, no como identidades permanentes.\n\nLa rareza, en resumen, no te dice cuánto vale una máscara. Te dice qué tipo de circuito vas a poder leer con ella.",
                'category' => 'Sistema',
                'author' => 'Archivo Kitsune',
                'published_at' => now()->subDays(5),
                'reading_time' => 5,
                'cover_tone' => 'violet',
                'is_featured' => true,
            ],
            [
                'title' => 'Nuevas señales desde el Distrito 09',
                'slug' => 'nuevas-senales-desde-el-distrito-09',
                'excerpt' => 'El circuito detectó actividad irregular en Akai Gate y nuevas identidades comenzaron a aparecer.',
                'body' => "Durante la última semana, los sensores de Akai Gate registraron un aumento sostenido de actividad. Las identidades que entraron al distrito muestran firmas que no estaban catalogadas en el archivo público hasta ahora.\n\nEl pulso de las puertas internas también cambió. Lo que antes era una validación de tres segundos hoy se extiende a casi diez. Algunos operadores creen que el circuito está revisando lecturas viejas; otros sospechan que está preparando un protocolo nuevo.\n\nPor ahora no hay anuncios oficiales. Si tu identidad pasa por Akai Gate, conviene calibrar antes de entrar y evitar los anillos internos en horario pico.",
                'category' => 'Novedades',
                'author' => 'Operador 09',
                'published_at' => now()->subDays(9),
                'reading_time' => 3,
                'cover_tone' => 'red',
                'is_featured' => true,
            ],
            [
                'title' => 'Kitsune, Oni y Karasu: tres formas de moverse por la ciudad',
                'slug' => 'kitsune-oni-karasu-tres-formas-de-moverse',
                'excerpt' => 'Velocidad, impacto y sigilo: tres estrategias para habitar el mercado nocturno.',
                'body' => "Kitsune es la identidad de tránsito. Su lectura es liviana, su firma se renueva rápido y rara vez deja huella. Es la máscara para cruzar muchos distritos en una misma noche, sin pelear con ningún protocolo.\n\nOni es la identidad de presencia. No se mueve, ocupa. Marca firma alta y abre puertas en zonas de combate, eventos cerrados y distritos prohibidos. No es una máscara discreta y no pretende serlo.\n\nKarasu es la identidad de observación. Firma baja, perfil neutro, lectura silenciosa. Sirve para moverse sin que el circuito te registre como evento. Es la máscara de quienes prefieren entender antes de intervenir.\n\nLas tres familias no compiten: se complementan. Lo importante no es elegir una para siempre, sino saber cuál te conviene esta noche.",
                'category' => 'Identidades',
                'author' => 'Archivo Kitsune',
                'published_at' => now()->subDays(14),
                'reading_time' => 6,
                'cover_tone' => 'magenta',
                'is_featured' => false,
            ],
            [
                'title' => 'Protocolo nocturno para nuevos usuarios',
                'slug' => 'protocolo-nocturno-para-nuevos-usuarios',
                'excerpt' => 'Reglas mínimas para entrar, reservar una máscara y no perder la señal en el primer recorrido.',
                'body' => "Antes de salir con una máscara nueva, conviene pasar por un punto de calibración. Es un trámite de tres minutos, no cuesta nada y previene la mayoría de los rechazos en los lectores principales del circuito.\n\nEn la primera salida, evitá los anillos internos de los distritos restringidos. Hacé una vuelta corta por una zona de tránsito libre, dejá que el circuito registre tu firma con calma y volvé. La máscara responde mejor cuando tiene un par de validaciones limpias en su historial reciente.\n\nSi reservás una identidad para una fecha futura, mantené el código del pedido a mano. Hasta que el carrito propio esté disponible en la próxima fase, las reservas se confirman manualmente desde el archivo del circuito.",
                'category' => 'Acceso',
                'author' => 'Operador del circuito',
                'published_at' => now()->subDays(20),
                'reading_time' => 4,
                'cover_tone' => 'gold',
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
