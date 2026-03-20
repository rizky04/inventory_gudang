<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $pageTitle = 'Data Product';
    public function index()
    {
        //
        $pageTitle = $this->pageTitle;
        // $query = Product::query();
        $perPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');
        $query = Product::query()->with('category');


        if($search){
            $query->where('name_product', 'like', '%' . $search . '%');
        }
        $product = $query->paginate($perPage)->appends(request()->query());
        // dd($product);
        confirmDelete('Delete Product ?');
        return view('product.index', compact('pageTitle', 'product'));
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
    public function store(StoreProductRequest $request)
    {
        Product::create([
            'name_product' => $request->name_product,
            'description_product' => $request->description_product,
            'category_product_id' => $request->category_product_id
        ]);
        toast()->success('Product success created');
        return redirect()->route('master-data.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $pageTitle = $this->pageTitle;
        return view('product.show', compact('product', 'pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->name_product = $request->name_product;
        $product->description_product = $request->description_product;
        $product->category_product_id = $request->category_product_id;
        $product->save();
        toast()->success('Product success Updated');
        return redirect()->route('master-data.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
       $product->delete();
       toast()->success('Product Success Deleted');
       return redirect()->route('master-data.product.index');
    }
}
