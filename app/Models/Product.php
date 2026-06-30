<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property string $category
 * @property string $rarity
 * @property string $district
 * @property int $price
 * @property string $short_description
 * @property string $long_description
 * @property string $dominant_color
 * @property string $status
 * @property int $signal_level
 * @property int $agility
 * @property int $spirit
 * @property int $ferocity
 * @property string|null $image_path
 * @property bool $is_featured
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 *
 * @method static Builder|Product featured()
 * @method static Builder|Product available()
 * @method static Builder|Product byFilter(?string $filter)
 */
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
     * Scope para filtrar productos destacados.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope para filtrar productos disponibles.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    /**
     * Scope para filtrar productos por categoría/filtro.
     *
     * @param Builder $query
     * @param string|null $filter
     * @return Builder
     */
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

    /**
     * Verificar si está disponible.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    /**
     * Verificar si tiene imagen.
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return $this->image_path !== null
            && $this->image_path !== ''
            && file_exists(public_path($this->image_path));
    }

    /**
     * Obtener el precio formateado.
     *
     * @return string
     */
    public function formattedPrice(): string
    {
        return '$' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Obtener la etiqueta de rareza.
     *
     * @return string
     */
    public function rarityLabel(): string
    {
        return $this->rarity;
    }

    /**
     * Obtener la etiqueta de estado.
     *
     * @return string
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'Disponible',
            self::STATUS_UPCOMING => 'Próxima',
            self::STATUS_SOLD_OUT => 'Agotada',
            default => ucfirst((string) $this->status),
        };
    }

    /**
     * Obtener el estilo de color dominante.
     *
     * @return string
     */
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

    /**
     * Obtener las reservas de esta máscara.
     *
     * @return HasMany<Reservation>
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Obtener los usuarios que reservaron esta máscara.
     *
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reservations', 'product_id', 'user_id')
            ->withPivot('status', 'created_at')
            ->withTimestamps();
    }
}
