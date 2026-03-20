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
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalFormVarian">Create Varian</button>
                </div>
                <div class="row mt-2">
                    @forelse ($product->varianProduct as $item)
                        <div class="col-4">
                            <x-product.card-variant :variant="$item" />
                        </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info" style="box-shadow: none;">
                            <span>data not avalaible</span>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <x-product.form-variant />
@endsection
@push('script')
    <script>
        $(document).ready(function() {
                    let modalEl = $('#modalFormVarian');
                    let modal = new bootstrap.Modal(modalEl);
                    let $form = $('#modalFormVarian form');

                    $("#btnTambahVarian").on('click', function() {
                        $form[0].reset();
                        $form.attr('action');
                        $form.find('small.text-danger').text('');
                        $('#modalFormVarianLabel .modal-title').text('Create Varian');
                        modal.show();
                    });

                    $form.submit(function(e) {
                        e.preventDefault();
                        let formData = new FormData(this);

                        $.ajax({
                            url: $(this).attr('action'),
                            method: $(this).attr('method'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                swal({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 1500,
                                }).then(() => {
                                    modal.hide();
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                let errors = xhr.responseJSON.errors;
                                console.log(errors);

                                $form.find('small.text-danger').text('');
                                $.each(errors, function(key, value) {
                                    $form.find('#' + key).next('small.text-danger').text(value[
                                        0]);
                                });
                            }
                        });
                    });
                });
    </script>
@endpush
