<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryProductFactory> */
    use HasFactory;
    protected $fillable = [
        'name_category'
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'category_product_id');
    }
}
