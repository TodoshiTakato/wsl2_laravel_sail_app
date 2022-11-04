<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Customized additions:

// Factory:
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Product\ProductFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'category_id',
    ];

    /**
     * Create a new factory instance for the model.
     * Nurlan's comment: it is for faker, seeding and etc.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order_item()
    {
        return $this->hasMany(OrderItem::class);
    }

//    public function getPriceAttribute($price)
//    {
//        return number_format($price, 2, ",", " ").' UZS';
//    }

}
