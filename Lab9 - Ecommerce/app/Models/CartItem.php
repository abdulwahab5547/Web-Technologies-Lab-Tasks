<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->with('category');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLineTotalAttribute(): float
    {
        return (float) $this->product->price * $this->quantity;
    }
}
