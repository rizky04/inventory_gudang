<div class="card">
    <div class="card-body">
        <img src="{{ asset('storage/variant-product/' . $variant->image_variant) }}" alt="{{ $variant->name_variant }}"  class="img-fluid mb-2" style="max-height: 300px; object-fit: cover; width:100%; height:100%;">
        <h5 class="card-title">{{ $variant->name_variant }}</h5>
        <x-meta-item label="SKU" value="{{ $variant->number_sku }}" />
        <x-meta-item label="Harga" value="Rp {{ number_format($variant->price_variant) }}" />
        <x-meta-item label="Stok" value="{{ number_format($variant->stok_variant) }}" />
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div class="w-100">
            <button type="button" class="btn btn-outline-primary btn-sm btnEditVarian" data-id="{{ $variant->id }}" data-name-variant="{{ $variant->name_variant }}" data-price-variant="{{ $variant->price_variant }}" data-stok-variant="{{ $variant->stok_variant }}" data-action="{{ route('master-data.variant-product.update', $variant->id) }}">edit</button>
        </div>
         <form action="{{ route('master-data.variant-product.destroy', $variant->id) }}" method="POST" class="d-inline formDeleteVariant">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">delete {{ $variant->id }}</button>
        </form>
    </div>
</div>
