<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'reading_time' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    public function formattedDate(): string
    {
        return $this->published_at?->format('d/m/Y') ?? '';
    }

    public function readingTimeLabel(): string
    {
        return $this->reading_time > 0
            ? $this->reading_time . ' min de lectura'
            : 'Lectura breve';
    }

    /**
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
