<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Customized additions:

// Factory:
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Category\CategoryFactory;

class Category extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * Create a new factory instance for the model.
     * Nurlan's comment: it is for faker, seeding and etc.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public static function parent_categories() {
        return static::where('parent_id', null)->get();
    }

    public function parent_category() {
        return $this->hasOne(self::class, 'parent_id', 'id');
    }
    public function child_category() {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

}
