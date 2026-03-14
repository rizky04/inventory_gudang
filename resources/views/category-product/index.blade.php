@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-body py-5">
        <div>
            <x-category-product.form-category-product />
        </div>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($category as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name_category }}</td>
                        <td>
                           <div class="d-flex align-items-center gap-1">
                             <x-category-product.form-category-product id="{{ $item->id }}" />
                            <x-confirm-delete route="master-data.category-product.destroy" id="{{ $item->id }}" />
                           </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Data Tidak Tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
