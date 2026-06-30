<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Reservation
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Product $product
 */
class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
    ];

    /**
     * Obtener el usuario que hizo la reserva.
     *
     * @return BelongsTo<User, Reservation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el producto reservado.
     *
     * @return BelongsTo<Product, Reservation>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
