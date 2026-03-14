<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public $pageTitle = 'Category Product';
    public function index()
    {
        $pageTitle = $this->pageTitle;
        $query = CategoryProduct::query();
        $category = $query->paginate(10);
        confirmDelete('Delete Category Product ?');
        return view('category-product.index', compact('pageTitle', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('category-product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryProductRequest $request)
    {
        CategoryProduct::create([
            'name_category' => $request->name_category
        ]);
        toast()->success('Category Product Success created');
        return redirect()->route('master-data.category-product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryProductRequest $request, CategoryProduct $categoryProduct)
    {
       $categoryProduct->name_category = $request->name_category;
       $categoryProduct->save();
       toast()->success('Category Product Success Updated');
       return redirect()->route('master-data.category-product.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        $categoryProduct->delete();
        toast()->success('Category Product Success Deleted');
        return redirect()->route('master-data.category-product.index');
    }
}
