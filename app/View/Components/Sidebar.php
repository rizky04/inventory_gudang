<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public $links;
    public function __construct()
    {
        $this->links = [
            [
                'label' => 'Dashboard Analitik',
                'route' => 'home',
                'is_active' => request()->routeIs('home'),
                'icon' => 'fas fa-chart-line',
                'is_dropdown' => false,
            ],
            [
                'label' => 'Master Data',
                'route' => '#',
                'is_active' => request()->routeIs('master-data.*'),
                'icon' => 'fas fa-cloud',
                'is_dropdown' => true,
                'items' => [
                    [
                        'label' => 'Category Product',
                        'route' => 'master-data.category-product.index'
                    ],
                    [
                        'label' => 'Data Product',
                        'route' => 'master-data.product.index'
                    ],
                    [
                        'label' => 'Stock Product',
                        'route' => 'master-data.stock-product.index',
                    ],
                ]
            ]
            ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
