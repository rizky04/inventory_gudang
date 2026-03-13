<?php

namespace App\View\Components\CategoryProduct;

use App\Models\CategoryProduct;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormCategoryProduct extends Component
{
    /**
     * Create a new component instance.
     */

    public $id, $name_category, $action;
    public function __construct($id = null)
    {
        if ($id) {
           $category = CategoryProduct::findOrFail($id);
           $this->id = $category->id;
           $this->name_category = $category->name_category;
           $this->action = route('master-data.category-product.update', $category->id);
        } else {
            $this->action = route('master-data.category-product.store');
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-product.form-category-product');
    }
}
