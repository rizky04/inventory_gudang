@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-body py-5">
        <div class="row align-items-center">
            <div class="row col-9 justify-content-between align-items-center">
                <div class="col-1">
                    <x-per-page-option />
                </div>
                <div class="col-8">
                    <x-filter-by-field term="search" placeholder="Search by SKU, Name, Category" />
                </div>
            </div>
            <div class="col-2">
                <x-filter-by-options term="category" :options="$category" field="name_category" defaultValue="chose Category" />
            </div>
            <div class="col-1">
                <x-buttong-reset-filter route="master-data.stock-product.index" />
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15px">No</th>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              @forelse ($product as $index => $item)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['number_sku'] }}</td>
                <td>{{ $item['product'] }}</td>
                <td>{{ $item['category'] }}</td>
                <td>{{ number_format($item['stok_variant']) }}</td>
                <td>{{ number_format($item['price']) }}</td>
                <td>
                    <x-card-stock number_sku="{{ $item['number_sku'] }}" />
                </td>
            </tr>
              @empty
                <td class="text-center" colspan="7">
                    Data not available
                </td>
              @endforelse
            </tbody>
        </table>
        {{ $product->links() }}
    </div>
</div>

@endsection
