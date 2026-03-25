<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantProduct extends Model
{
    protected $fillable = [
        'product_id',
        'number_sku',
        'name_variant',
        'image_variant',
        'price_variant',
        'stok_variant',
    ];

    public static function generateNumberSku(){
        $maxId = self::max('id');
        $prefix = "SKU";
        $numberSku = $prefix . str_pad($maxId + 1, 6, '0', STR_PAD_LEFT);
        return $numberSku;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
