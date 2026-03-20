<div class="col-md-4 col-lg-3">
            <div class="card card-post card-round" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <img class="card-img-top"
                     src="{{ $variant->image_variant ? asset('storage/varian-product/' . $variant->image_variant) : asset('assets/img/no-image.jpg') }}"
                     alt="{{ $variant->name_variant }}"
                     style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="text-muted small mb-1">SKU: {{ $variant->number_sku }}</p>
                        <span class="badge {{ $variant->stok_variant > 0 ? 'badge-success' : 'badge-danger' }}">
                            Stok: {{ $variant->stok_variant }}
                        </span>
                    </div>
                    <h5 class="card-title fw-bold">{{ $variant->name_variant }}</h5>
                    <p class="card-text text-primary fw-bold">
                        Rp {{ number_format($variant->price_variant, 0, ',', '.') }}
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-between bg-transparent border-top-0">
                    <button class="btn btn-icon btn-link btn-primary">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-icon btn-link btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
