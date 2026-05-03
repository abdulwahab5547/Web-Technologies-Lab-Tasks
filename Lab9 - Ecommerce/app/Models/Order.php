<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'subtotal',
        'shipping',
        'total',
        'shipping_address',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'subtotal'         => 'decimal:2',
        'shipping'         => 'decimal:2',
        'total'            => 'decimal:2',
    ];

    public const STATUSES = [
        'pending'    => 'Pending',
        'processing' => 'Processing',
        'shipped'    => 'Shipped',
        'delivered'  => 'Delivered',
        'cancelled'  => 'Cancelled',
    ];

    public const STATUS_COLORS = [
        'pending'    => 'bg-amber-100 text-amber-700 border-amber-200',
        'processing' => 'bg-brand-100 text-brand-700 border-brand-200',
        'shipped'    => 'bg-indigo-100 text-indigo-700 border-indigo-200',
        'delivered'  => 'bg-green-100 text-green-700 border-green-200',
        'cancelled'  => 'bg-red-100 text-red-700 border-red-200',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
    }

    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }
}
