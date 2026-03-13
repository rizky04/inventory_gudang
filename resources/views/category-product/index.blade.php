@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-body py-5">
        <div>
            <x-category-product.form-category-product />
        </div>
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($category as $index => $item)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name_category }}</td>
                        <td>
                            <x-category-product.form-category-product id="{{ $item->id }}" />
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