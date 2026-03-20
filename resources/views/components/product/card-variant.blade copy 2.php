<div class="card card-round h-100 mb-4" style="border: 1px solid #ebedf2; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: transform 0.2s;">
    <div style="position: relative; overflow: hidden; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <img class="card-img-top"
             src="{{ $variant->image_variant ? asset('storage/varian-product/' . $variant->image_variant) : asset('assets/img/no-image.jpg') }}"
             alt="{{ $variant->name_variant }}"
             style="height: 160px; width: 100%; object-fit: cover; display: block;">

        <span class="badge {{ $variant->stok_variant > 0 ? 'badge-success' : 'badge-danger' }}"
              style="position: absolute; top: 10px; right: 10px; z-index: 1;">
            Stok: {{ $variant->stok_variant }}
        </span>
    </div>

    <div class="card-body p-3">
        <div class="d-flex flex-column">
            <small class="text-muted fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px; text-transform: uppercase;">
                SKU: {{ $variant->number_sku ?? '-' }}
            </small>
            <h5 class="card-title text-dark fw-bold mb-2" style="font-size: 16px; line-height: 1.2;">
                {{ $variant->name_variant }}
            </h5>
            <h4 class="text-primary fw-bold mb-0">
                Rp {{ number_format($variant->price_variant, 0, ',', '.') }}
            </h4>
        </div>
    </div>

    <div class="card-footer p-2 bg-light d-flex justify-content-around border-top-0" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
        <button class="btn btn-link btn-primary p-2" title="Edit Varian">
            <i class="fa fa-edit"></i>
        </button>
        <button class="btn btn-link btn-danger p-2" title="Hapus Varian">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</div>

<style>
    .card-round:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
