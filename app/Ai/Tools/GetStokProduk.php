<?php

namespace App\Ai\Tools;

use App\Models\VariantProduct;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetStokProduk implements Tool
{
    public function description(): Stringable|string
    {
        return 'Mengambil daftar semua varian produk beserta stok saat ini dari database gudang. Gunakan tool ini ketika pengguna bertanya tentang stok barang, ketersediaan produk, atau jumlah inventaris.';
    }

    public function handle(Request $request): Stringable|string
    {
        $variants = VariantProduct::with('product.category')
            ->orderBy('stok_variant', 'asc')
            ->get();

        if ($variants->isEmpty()) {
            return 'Tidak ada data produk di database.';
        }

        $lines = ['=== DATA STOK PRODUK ==='];

        foreach ($variants as $v) {
            $produkNama  = $v->product?->name_product ?? 'Tidak diketahui';
            $kategori    = $v->product?->category?->name_category ?? 'Tidak diketahui';
            $stokStatus  = $v->stok_variant <= 5 ? ' ⚠️ STOK MENIPIS' : '';
            $lines[] = "- [{$v->number_sku}] {$produkNama} / {$v->name_variant} | Stok: {$v->stok_variant} | Harga: Rp " . number_format($v->price_variant, 0, ',', '.') . " | Kategori: {$kategori}{$stokStatus}";
        }

        $total = $variants->count();
        $habis = $variants->where('stok_variant', 0)->count();
        $menipis = $variants->where('stok_variant', '>', 0)->where('stok_variant', '<=', 5)->count();

        $lines[] = '';
        $lines[] = "Total varian: {$total} | Stok habis: {$habis} | Stok menipis (≤5): {$menipis}";

        return implode("\n", $lines);
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
