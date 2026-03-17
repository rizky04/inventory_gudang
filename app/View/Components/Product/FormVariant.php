<?php

namespace App\View\Components\product;

use App\Models\VarianProduct;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormVariant extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $product_id, $name_variant, $price_variant, $stok_variant, $action;
    public function __construct($id = null)
    {
        $this->product_id = request()->route('product')->id;
        if ($id) {
            $variant = VarianProduct::findOrdFail($id);
            $this->id = $variant->id;
            $this->name_variant = $variant->name_variant;
            $this->price_variant = $variant->price_variant;
            $this->stok_variant = $variant->stok_variant;
            $this->action = route('master-data.variant-product.update', $variant->id);
        } else {
            $this->action = route('master-data.variant-product.store');
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product.form-variant');
    }
}
