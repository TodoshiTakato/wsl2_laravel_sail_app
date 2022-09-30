<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function order_item()
    {
        return $this->hasMany('App\OrderItem');
    }

//    public function getPriceAttribute($price)
//    {
//        return number_format($price, 2, ",", " ").' UZS';
//    }

}
