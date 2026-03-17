<?php

namespace App\View\Components\Product;

use App\Models\CategoryProduct;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $name_product, $description_product, $category_product_id, $category, $action;
    public function __construct($id = null)
    {
        $this->category = CategoryProduct::all();
        if ($id) {
            $product = Product::findOrFail($id);
            $this->id = $product->id;
            $this->name_product = $product->name_product;
            $this->description_product = $product->description_product;
            $this->category_product_id = $product->category_product_id;
            $this->action = route('master-data.product.update', $product->id);
        } else {
            $this->action = route('master-data.product.store');
        }


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product.form-product');
    }
}
