<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\VariantProduct;
use Illuminate\Http\Request;

class StockProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $pageTitle = 'Stock Product';
    public function index()
    {

        $pageTitle = $this->pageTitle;
        $category = CategoryProduct::all();
        $perPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');

        $rCategory = request()->query('category');

        $query = VariantProduct::query();

        $query = $query->with('product', 'product.category');

        if ($search) {
            $query->where('name_variant', 'like', '%' . $search . '%')
                    ->orWhere('number_sku', 'like', '%' . $search . '%')
                    ->orWhereHas('product', function ($query) use ($search) {
                        $query->where('name_product', 'like', '%' . $search . '%');
                    });
        }

        if ($rCategory) {
            $query->whereHas('product', function ($query) use ($rCategory) {
                $query->where('category_product_id', $rCategory);
            });
        }

        $paginator = $query->paginate($perPage)->appends(request()->query());
        $product = $paginator->getCollection()->map(function ($q) {
            return [
                'variant_id' => $q->id,
                'number_sku' => $q->number_sku,
                'product' => $q->product->name_product . " " . $q->name_variant,
                'category' => $q->product->category->name_category,
                'stok_variant' => $q->stok_variant,
                'price' => $q->price_variant,
            ];
        });

        $paginator->setCollection($product);

        $product = $paginator;

        return view('stock-product.index', compact('pageTitle', 'product', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
