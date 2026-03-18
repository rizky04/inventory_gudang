<div>
    <div class="modal fade" id="modalFormVarian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFormVarianLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalFormVarianLabel">Form variant</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name_variant" class="form-label">Name Variant</label>
                    <input type="text" class="form-control" id="name_variant" placeholder="Name Variant" value="{{ old('name_variant', $name_variant ?? '') }}">
                    <small class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="price_variant" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price_variant" placeholder="Price" value="{{ old('price_variant', $price_variant ?? '') }}">
                    <small class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="stok_variant" class="form-label">Stock Variant</label>
                    <input type="number" class="form-control" id="stok_variant" placeholder="Stok Variant" value="{{ old('stok_variant', $stok_variant ?? '') }}">
                    <small class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label for="image_variant" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image_variant" name="image_variant" placeholder="Image Variant">
                    <small class="text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">save</button>
            </div>
          </div>
        </div>
      </div>
</div>