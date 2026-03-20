<?php

namespace App\Http\Controllers;

use App\Models\VarianProduct;
use App\Http\Requests\StoreVarianProductRequest;
use App\Http\Requests\UpdateVarianProductRequest;
use Illuminate\Support\Facades\Storage;

class VarianProductController extends Controller
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
    public function store(StoreVarianProductRequest $request)
    {
        $fileName = time() . '.' . $request->file('image_variant')->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('varian-product', $request->file('image_variant'), $fileName);

        VarianProduct::create([
            'product_id' => $request->product_id,
            'number_sku' => VarianProduct::generateNumberSku(),
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
    public function show(VarianProduct $varianProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VarianProduct $varianProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVarianProductRequest $request, VarianProduct $varianProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VarianProduct $varianProduct)
    {
        //
    }
}
