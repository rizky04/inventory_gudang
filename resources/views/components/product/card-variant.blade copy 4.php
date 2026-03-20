<div class="card h-80 border-0 shadow-sm variant-card-hover" style="border-radius: 12px; overflow: hidden;">
    <div class="position-relative w-100" style="aspect-ratio: 4/3; overflow: hidden;">
        <img class="w-100 h-100"
             src="{{ $variant->image_variant ? asset('storage/varian-product/' . $variant->image_variant) : asset('assets/img/no-image.jpg') }}"
             alt="{{ $variant->name_variant }}"
             style="object-fit: cover;">

        <span class="badge rounded-pill {{ $variant->stok_variant > 0 ? 'bg-success' : 'bg-danger' }} position-absolute"
              style="top: 12px; right: 12px; z-index: 2; box-shadow: 0 2px 10px rgba(0,0,0,0.15);">
            <i class="fas fa-box-open me-1" style="font-size: 10px;"></i>
            {{ $variant->stok_variant }}
        </span>
    </div>

    <div class="card-body p-3 d-flex flex-column">
        <div class="text-muted fw-bold mb-1 tracking-wider" style="font-size: 10px; text-transform: uppercase;">
            SKU: {{ $variant->number_sku ?? '-' }}
        </div>

        <h6 class="card-title text-dark fw-bold mb-2 text-truncate-2" title="{{ $variant->name_variant }}">
            {{ $variant->name_variant }}
        </h6>

        <div class="mt-auto">
            <p class="text-primary fw-bolder mb-0 fs-5">
                Rp{{ number_format($variant->price_variant, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
        <div class="d-grid gap-2 d-flex justify-content-between">
            <button class="btn btn-outline-primary btn-sm flex-fill rounded-3" title="Edit">
                <i class="fa fa-edit"></i> Edit
            </button>
            <button class="btn btn-outline-danger btn-sm rounded-3 px-3" title="Hapus">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</div>
<style>
    /* Hover Effect yang lebih smooth */
    .variant-card-hover {
        transition: transform 0.25s cubic-bezier(.4,0,.2,1), box-shadow 0.25s ease;
    }

    .variant-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.125) !important;
    }

    /* Clamp Text (Support untuk BS5) */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.8rem; /* Menjaga konsistensi tinggi jika teks pendek */
        line-height: 1.4;
    }

    .tracking-wider {
        letter-spacing: 0.05rem;
    }

    /* Opsional: Efek zoom pada gambar saat card di-hover */
    .variant-card-hover:hover img {
        transform: scale(1.05);
        transition: transform 0.5s ease;
    }
</style>
