@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-body py-5">
       <div class="row">
        <div class="row col-10 align-items-center justify-content-between">
            <div class="col-1">
                <x-per-page-option />
            </div>
            <div class="col-9">
                <x-filter-by-field term="search" placeholder="Search category product..." />
            </div>
            <div class="col-1">
                <x-buttong-reset-filter route="master-data.product.index"/>
            </div>
        </div>
         <div class="col-2 d-flex justify-content-end">
            <x-product.form-product/>
        </div>
       </div>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($product as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <a href="{{ route('master-data.product.show', $item->id) }}" class="text-decoration-none">
                                {{ $item->name_product }}
                            </a>
                        </td>
                        <td><span class="badge bg-primary">{{ $item->category->name_category }}</span></td>
                        <td>{{ $item->description_product }} {{ $item->id }}</td>
                        <td>
                           <div class="d-flex align-items-center gap-1">
                             <x-product.form-product id="{{ $item->id }}" />
                            <x-confirm-delete route="master-data.product.destroy" id="{{ $item->id }}" />
                           </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data Tidak Tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $product->links() }}
    </div>
</div>
@endsection
