@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15px">No</th>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection
