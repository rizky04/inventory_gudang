@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Detail : {{ $product->name_product }}</h4>
        <a href="{{ route('master-data.product.index') }}" class="text-primary"></a>
    </div>
    <div class="card-body py-5">
        <x-meta-item label="Product Name" value="{{ $product->name_product }}" />
        <x-meta-item label="Category Name" value="{{ $product->category->name_category }}" />
        <x-meta-item label="Description" value="{{ $product->description_product }}" />
        <div class="mt-2">
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalFormVarian">Create Varian</button>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="alert alert-info" style="box-shadow: none;">
                        <span>data not avalaible</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-product.form-variant />
@endsection
