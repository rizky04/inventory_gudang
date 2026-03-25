<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVariantProductRequest;
use App\Http\Requests\UpdateVariantProductRequest;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\Storage;

class VariantProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreVariantProductRequest $request)
    {
         $fileName = time() . '.' . $request->file('image_variant')->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('variant-product', $request->file('image_variant'), $fileName);

        VariantProduct::create([
            'product_id' => $request->product_id,
            'number_sku' => VariantProduct::generateNumberSku(),
            'name_variant' => $request->name_variant,
            'image_variant' => $fileName,
            'price_variant' => $request->price_variant,
            'stok_variant' => $request->stok_variant,
        ]);
        // toast()->success('Product success created');
        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(VariantProduct $variantProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VariantProduct $variantProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateVariantProductRequest $request, VariantProduct $variant_product)
{
    // HAPUS BARIS INI: $variant = VariantProduct::findOrFail($variant_product);
    // Langsung gunakan $variant_product

    $fileName = $variant_product->image_variant;

    if ($request->hasFile('image_variant')) {
        // Hapus foto lama jika ada
        if ($fileName) {
            Storage::disk('public')->delete('variant-product/' . $fileName);
        }

        $file = $request->file('image_variant');
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        // Simpan file baru ke folder 'variant-product'
        $file->storeAs('variant-product', $fileName, 'public');
    }

    $variant_product->update([
        'product_id'    => $request->product_id,
        'name_variant'  => $request->name_variant,
        'image_variant' => $fileName,
        'price_variant' => $request->price_variant,
        'stok_variant'  => $request->stok_variant,
    ]);

    return response()->json(['message' => 'Data berhasil diupdate']);
}

public function destroy(VariantProduct $variant_product)
{
    // HAPUS BARIS INI: $variant = VariantProduct::findOrFail($variant_product);

    // Hapus gambar dari storage
    if ($variant_product->image_variant) {
        Storage::disk('public')->delete('variant-product/' . $variant_product->image_variant);
    }

    $productId = $variant_product->product_id;
    $variant_product->delete();

    toast()->success('Data berhasil dihapus');

    return redirect()->route('master-data.product.show', $productId);
}
}
