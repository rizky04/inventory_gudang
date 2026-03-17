<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianProduct extends Model
{
    /** @use HasFactory<\Database\Factories\VarianProductFactory> */
    use HasFactory;
    protected $fillable = [
        'product_id',
        'number_sku',
        'name_variant',
        'image_variant',
        'price_variant',
        'stok_variant',
    ];
}
