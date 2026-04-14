<?php

namespace App\Ai\Tools;

use App\Models\Product;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CariProduk implements Tool
{
    public function description(): Stringable|string
    {
        return 'Mencari produk berdasarkan nama atau kata kunci. Gunakan tool ini ketika pengguna mencari produk tertentu, ingin tahu detail produk, atau menanyakan apakah suatu barang tersedia.';
    }

    public function handle(Request $request): Stringable|string
    {
        $keyword = $request['keyword'] ?? '';

        $products = Product::with(['category', 'variantProduct'])
            ->where('name_product', 'like', "%{$keyword}%")
            ->orWhere('description_product', 'like', "%{$keyword}%")
            ->get();

        if ($products->isEmpty()) {
            return "Tidak ditemukan produk dengan kata kunci: '{$keyword}'";
        }

        $lines = ["=== HASIL PENCARIAN: '{$keyword}' ==="];

        foreach ($products as $p) {
            $kategori   = $p->category?->name_category ?? 'Tidak diketahui';
            $totalStok  = $p->variantProduct->sum('stok_variant');
            $lines[] = "- {$p->name_product} | Kategori: {$kategori} | Total Stok: {$totalStok}";

            foreach ($p->variantProduct as $v) {
                $lines[] = "    • [{$v->number_sku}] {$v->name_variant} | Stok: {$v->stok_variant} | Harga: Rp " . number_format($v->price_variant, 0, ',', '.');
            }
        }

        return implode("\n", $lines);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'keyword' => $schema->string()->description('Kata kunci nama produk yang ingin dicari')->required(),
        ];
    }
}
