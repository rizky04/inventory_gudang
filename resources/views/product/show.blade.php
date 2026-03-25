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
                    @forelse ($product->variantProduct as $item)
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

                    $(".btnEditVarian").on('click', function() {
                        let name_variant = $(this).data('name-variant');
                        let price_variant = $(this).data('price-variant');
                        let stok_variant = $(this).data('stok-variant');
                        let action = $(this).data('action');

                        $form[0].reset();
                        $form.attr('action', action);
                        $form.find('small.text-danger').text('');
                        $form.append('<input type="hidden" name="_method" value="PUT">');
                        $form.find('#name_variant').val(name_variant);
                        $form.find('#price_variant').val(price_variant);
                        $form.find('#stok_variant').val(stok_variant);
                        $('#modalFormVarianLabel .modal-title').text('Edit Varian');
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

                        $('.formDeleteVariant').submit(function(e) {
                            e.preventDefault();
                            let form = this;
                            swal({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                buttons: true,
                                dangerMode: true,
                            }).then((isConfirm) => {
                                if (isConfirm) {
                                    form.submit();
                                }
                            });
                        });
                });
    </script>
@endpush
