<?php

namespace App\Ai\Tools;

use App\Models\CategoryProduct;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetKategoriProduk implements Tool
{
    public function description(): Stringable|string
    {
        return 'Mengambil daftar semua kategori produk beserta jumlah produk di tiap kategori. Gunakan tool ini ketika pengguna bertanya tentang kategori barang atau klasifikasi produk.';
    }

    public function handle(Request $request): Stringable|string
    {
        $categories = CategoryProduct::withCount('product')->get();

        if ($categories->isEmpty()) {
            return 'Tidak ada data kategori di database.';
        }

        $lines = ['=== DATA KATEGORI PRODUK ==='];

        foreach ($categories as $cat) {
            $lines[] = "- {$cat->name_category} | Jumlah produk: {$cat->product_count}";
        }

        return implode("\n", $lines);
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
