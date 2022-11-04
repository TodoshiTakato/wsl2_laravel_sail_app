<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Customized additions:

// Factory:
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\OrderItem\OrderItemFactory;


class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'item_price',
        'order_id',
        'product_id',
    ];

    /**
     * Create a new factory instance for the model.
     * Nurlan's comment: it is for faker, seeding and etc.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return OrderItemFactory::new();
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function setItemPriceAttribute ($quantity) {
        $price = $this->product->price;
        $this->attributes['item_price'] = ($price*$quantity);
    }

}
