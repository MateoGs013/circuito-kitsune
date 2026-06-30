<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $excerpt
 * @property string $body
 * @property string $category
 * @property string $author
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $reading_time
 * @property string $cover_tone
 * @property bool $is_featured
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static Builder|Post featured()
 * @method static Builder|Post published()
 */
class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'category',
        'author',
        'published_at',
        'reading_time',
        'cover_tone',
        'is_featured',
        'image_path',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'reading_time' => 'integer',
    ];

    /**
     * Obtener el nombre del campo para las rutas de Eloquent.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope para filtrar posts destacados.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para filtrar posts ya publicados.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Verificar si el post está publicado.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    /**
     * Verificar si el post tiene una imagen cargada.
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return $this->image_path !== null && $this->image_path !== '';
    }

    /**
     * Obtener la fecha formateada.
     *
     * @return string
     */
    public function formattedDate(): string
    {
        return $this->published_at?->format('d/m/Y') ?? '';
    }

    /**
     * Obtener la etiqueta del tiempo de lectura.
     *
     * @return string
     */
    public function readingTimeLabel(): string
    {
        return $this->reading_time > 0
            ? $this->reading_time . ' min de lectura'
            : 'Lectura breve';
    }

    /**
     * Desglosar el cuerpo en párrafos.
     *
     * @return list<string>
     */
    public function formattedBody(): array
    {
        $body = trim((string) $this->body);

        if ($body === '') {
            return [];
        }

        return preg_split("/\n\s*\n/", $body) ?: [];
    }
}
