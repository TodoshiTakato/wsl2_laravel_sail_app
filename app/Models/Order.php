<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Customized additions:

// Factory:
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Order\OrderFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'paid',
        'paid_at',
        'user_id',
    ];

    /**
     * Create a new factory instance for the model.
     * Nurlan's comment: it is for faker, seeding and etc.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
