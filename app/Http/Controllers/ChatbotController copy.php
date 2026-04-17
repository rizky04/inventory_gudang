<?php

namespace App\Http\Controllers;

use App\Ai\Agents\AssistantGudang;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\VariantProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    public function index()
    {
        $history = Session::get('chat_history', []);
        return view('chatbot.index', compact('history'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $userMessage = $request->message;

        try {
            $context = $this->buildDatabaseContext();
            $promptWithContext = $context . "\n\n---\nPertanyaan user: " . $userMessage;

            $response  = (new AssistantGudang)->prompt($promptWithContext);
            $aiReply   = (string) $response;

            // Cek apakah AI merespons dengan perintah JSON
            $command = $this->extractJsonCommand($aiReply);
            if ($command) {
                $aiReply = $this->executeCommand($command);
            }

            $history   = Session::get('chat_history', []);
            $history[] = ['role' => 'user',      'content' => $userMessage];
            $history[] = ['role' => 'assistant', 'content' => $aiReply];
            Session::put('chat_history', array_slice($history, -10));

            return response()->json(['reply' => $aiReply]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Maaf, sistem AI sedang gangguan: ' . $e->getMessage()], 500);
        }
    }

    public function clear()
    {
        Session::forget('chat_history');
        return response()->json(['success' => true]);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function buildDatabaseContext(): string
    {
        $lines = ['=== DATA INVENTARIS GUDANG (real-time) ==='];

        $variants = VariantProduct::with('product.category')->orderBy('stok_variant')->get();

        if ($variants->isNotEmpty()) {
            $lines[] = "\n** DAFTAR STOK PRODUK **";
            foreach ($variants as $v) {
                $produk   = $v->product?->name_product ?? '-';
                $kategori = $v->product?->category?->name_category ?? '-';
                $status   = $v->stok_variant == 0 ? ' [HABIS]' : ($v->stok_variant <= 5 ? ' [MENIPIS]' : '');
                $lines[]  = "- [{$v->number_sku}] {$produk} / {$v->name_variant} | Stok: {$v->stok_variant}{$status} | Harga: Rp " . number_format($v->price_variant, 0, ',', '.') . " | Kategori: {$kategori}";
            }
            $habis   = $variants->where('stok_variant', 0)->count();
            $menipis = $variants->where('stok_variant', '>', 0)->where('stok_variant', '<=', 5)->count();
            $lines[] = "\nRingkasan: Total {$variants->count()} varian | Habis: {$habis} | Menipis: {$menipis}";
        } else {
            $lines[] = "Belum ada data produk.";
        }

        $categories = CategoryProduct::withCount('product')->get();
        if ($categories->isNotEmpty()) {
            $lines[] = "\n** KATEGORI PRODUK **";
            foreach ($categories as $cat) {
                $lines[] = "- {$cat->name_category} ({$cat->product_count} produk)";
            }
        }

        return implode("\n", $lines);
    }

    private function extractJsonCommand(string $aiReply): ?array
    {
        // Cari blok ```json ... ``` atau JSON mentah
        if (preg_match('/```json\s*(\{.*?\})\s*```/s', $aiReply, $matches)) {
            $decoded = json_decode($matches[1], true);
            return (is_array($decoded) && isset($decoded['action'])) ? $decoded : null;
        }

        // Fallback: cari JSON langsung
        if (preg_match('/\{[^{}]*"action"\s*:[^{}]*\}/s', $aiReply, $matches)) {
            $decoded = json_decode($matches[0], true);
            return (is_array($decoded) && isset($decoded['action'])) ? $decoded : null;
        }

        return null;
    }

    private function executeCommand(array $command): string
    {
        $action = $command['action'] ?? '';
        $data   = $command['data']   ?? [];

        return match ($action) {
            'add_category' => $this->addCategory($data),
            'add_product'  => $this->addProduct($data),
            'add_variant'  => $this->addVariant($data),
            default        => 'Perintah tidak dikenali.',
        };
    }

    private function addCategory(array $data): string
    {
        $name = trim($data['name_category'] ?? '');
        if (! $name) {
            return 'Gagal: nama kategori tidak boleh kosong.';
        }

        if (CategoryProduct::where('name_category', $name)->exists()) {
            return "Kategori **{$name}** sudah ada di database.";
        }

        CategoryProduct::create(['name_category' => $name]);
        return "Kategori **{$name}** berhasil ditambahkan.";
    }

    private function addProduct(array $data): string
    {
        $name        = trim($data['name_product']      ?? '');
        $categoryName = trim($data['category_name']    ?? '');
        $description = trim($data['description_product'] ?? '');

        if (! $name) {
            return 'Gagal: nama produk tidak boleh kosong.';
        }

        $category = CategoryProduct::where('name_category', $categoryName)->first();
        if (! $category) {
            return "Gagal: kategori **{$categoryName}** tidak ditemukan. Tambahkan kategorinya dulu.";
        }

        $product = Product::create([
            'category_product_id' => $category->id,
            'name_product'        => $name,
            'description_product' => $description,
        ]);

        return "Produk **{$product->name_product}** berhasil ditambahkan ke kategori **{$category->name_category}**.";
    }

    private function addVariant(array $data): string
    {
        $productName = trim($data['product_name'] ?? '');
        $nameVariant = trim($data['name_variant'] ?? '');
        $price       = (int) ($data['price_variant'] ?? 0);
        $stock       = (int) ($data['stok_variant']  ?? 0);

        if (! $productName || ! $nameVariant) {
            return 'Gagal: nama produk dan nama varian tidak boleh kosong.';
        }

        $product = Product::where('name_product', $productName)->first();
        if (! $product) {
            return "Gagal: produk **{$productName}** tidak ditemukan. Tambahkan produknya dulu.";
        }

        $sku     = VariantProduct::generateNumberSku();
        $variant = VariantProduct::create([
            'product_id'   => $product->id,
            'number_sku'   => $sku,
            'name_variant' => $nameVariant,
            'price_variant' => $price,
            'stok_variant'  => $stock,
        ]);

        return "Varian **{$variant->name_variant}** (SKU: `{$sku}`) berhasil ditambahkan ke produk **{$product->name_product}** dengan stok {$stock} dan harga Rp " . number_format($price, 0, ',', '.') . ".";
    }
}
