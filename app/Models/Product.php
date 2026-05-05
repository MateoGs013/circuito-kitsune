<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const STATUS_AVAILABLE = 'disponible';
    public const STATUS_UPCOMING = 'próxima';
    public const STATUS_SOLD_OUT = 'agotada';

    protected $fillable = [
        'name',
        'slug',
        'code',
        'category',
        'rarity',
        'district',
        'price',
        'short_description',
        'long_description',
        'dominant_color',
        'status',
        'signal_level',
        'agility',
        'spirit',
        'ferocity',
        'image_path',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_featured' => 'boolean',
        'signal_level' => 'integer',
        'agility' => 'integer',
        'spirit' => 'integer',
        'ferocity' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeByFilter(Builder $query, ?string $filter): Builder
    {
        return match ($filter) {
            'disponibles' => $query->where('status', self::STATUS_AVAILABLE),
            'proximas' => $query->where('status', self::STATUS_UPCOMING),
            'agotadas' => $query->where('status', self::STATUS_SOLD_OUT),
            'raras' => $query->whereIn('rarity', ['Rara de señal', 'Sombra', 'Inestable']),
            'legendarias' => $query->whereIn('rarity', ['Legendaria', 'Prohibida', 'Fantasma']),
            default => $query,
        };
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function hasImage(): bool
    {
        return $this->image_path !== null
            && $this->image_path !== ''
            && file_exists(public_path($this->image_path));
    }

    public function formattedPrice(): string
    {
        return '$' . number_format($this->price, 0, ',', '.');
    }

    public function rarityLabel(): string
    {
        return $this->rarity;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'Disponible',
            self::STATUS_UPCOMING => 'Próxima',
            self::STATUS_SOLD_OUT => 'Agotada',
            default => ucfirst((string) $this->status),
        };
    }

    public function dominantColorStyle(): string
    {
        $palette = [
            'cyan' => '#22d3ee',
            'red' => '#ef4444',
            'violet' => '#8b5cf6',
            'gold' => '#f59e0b',
            'magenta' => '#ec4899',
            'blue' => '#3b82f6',
        ];

        $hex = $palette[$this->dominant_color] ?? '#737373';

        return "background-color: {$hex};";
    }
}
