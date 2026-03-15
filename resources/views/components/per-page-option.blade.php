<div>
    <select name="perPage" id="perPage" class="form-control" onchange="window.location.href = '?perPage=' + this.value" style="width: 100px">
        <option value="">Per Page</option>
        @foreach ($perPageOptions as $item)
            <option value="{{ $item }}">{{ $item }}</option>
        @endforeach
    </select>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
</div>
