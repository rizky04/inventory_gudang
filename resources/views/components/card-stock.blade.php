@props(['number_sku'])
<div>
   <!-- Button trigger modal -->
<button type="button" class="btn btn-default btn-card-stock text-primary" data-bs-toggle="modal" data-bs-target="#cardStockModal" data-number-sku="{{ $number_sku }}">
  Card Stok
</button>

<!-- Modal -->
<div class="modal fade" id="cardStockModal" tabindex="-1" aria-labelledby="cardStockModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cardStockModalLabel">Card Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table" id="table-card-stock">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Date</th>
              <th scope="col">Number Transaction</th>
              <th scope="col">Note</th>
              <th scope="col">Amount out</th>
              <th scope="col">Amount in</th>
                <th scope="col">After Stock</th>
                <th scope="col">User</th>
            </tr>
          </thead>
          <tbody>
            <!-- Data will be populated here via JavaScript -->
          </tbody>

        </table>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>
</div>
