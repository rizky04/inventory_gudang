<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'category_product_id',
        'name_product',
        'description_product',
    ];

    public function category(){
        return $this->belongsTo(CategoryProduct::class);
    }
}
