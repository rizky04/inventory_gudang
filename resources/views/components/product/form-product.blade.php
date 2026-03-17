<div>
    <!-- Button trigger modal -->
<button type="button" class="btn btn-round {{ $id ? 'btn-primary btn-icon' : 'btn-dark' }}" data-bs-toggle="modal" data-bs-target="#formCategory{{ $id ?? '' }}">
    @if ($id)
        <i class="fas fa-edit"></i>
    @else
      <span>New Product</span>
    @endif
  </button>

  <!-- Modal -->
  <div class="modal fade" id="formCategory{{ $id ?? '' }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="formCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
       <form action="{{ $action }}" method="POST">
        @csrf
        @if ($id)
        @method('PUT')
        @endif
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="formCategoryLabel">Form Product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="category_product_id" class="form-label">Category Product</label>
                <select name="category_product_id" id="category_product_id" class="form-control">
                    @foreach ($category as $item)
                    <option value="{{ $item->id }}">{{ $item->name_category }}</option>
                    @endforeach
                </select>
                @error('category_product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="name_product" class="form-label">Name Product</label>
                <input type="text" name="name_product" id="name_product" class="form-control @error('name_product') is-invalid @enderror" value="{{ old('name_product', $name_product ?? '') }}">
                @error('name_product')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description_product" class="form-label">Description Product</label>
                {{-- <input type="text" name="description_product" id="description_product" class="form-control @error('description_product') is-invalid @enderror" value="{{ old('description_product', $description_product ?? '') }}"> --}}
                <textarea type="text" name="description_product" id="description_product" class="form-control @error('description_product') is-invalid @enderror" value="{{ old('description_product', $description_product ?? '') }}" cols="30" rows="10">{{ old('description_product', $description_product ?? '') }}</textarea>
                @error('description_product')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
       </form>
      </div>
    </div>
  </div>
</div>
