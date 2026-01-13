@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Purchase</h5>
        <p class="fs-12">Update Purchase</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                {{ html()->form('POST')->route('purchase.update', encrypt($purchase->id))->attribute('id', 'purchaseItemsForm')->class('')->open() }}
                <table id="apptTable" class="table table-round align-middle mb-0 table-hover w-100 mt-2 border-top">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">Product</th>
                            <th class="py-2 fw-medium small text-uppercase">Batch</th>
                            <th class="py-2 fw-medium small text-uppercase">Expiry</th>
                            <th class="py-2 fw-medium small text-uppercase">Qty</th>
                            <th class="py-2 fw-medium small text-uppercase">P.Price</th>
                            <th class="py-2 fw-medium small text-uppercase">S.Price</th>
                            <th class="py-2 fw-medium small text-uppercase">Total</th>
                            <th class="py-2 fw-medium small text-uppercase">Remove</th>
                        </tr>
                    </thead>
                    <tbody class="purchaseItem">
                        @forelse($purchase->details as $key => $item)
                        <tr>
                            <td>
                                <input type="hidden" name="product_id[]" value="{{ $item->product->id }}" class="slctdPct"><input type="text" name="product[]" value="{{ $item->product->name }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="batch[]" value="{{ $item->batch }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="expiry[]" value="{{ $item->expiry }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="qty[]" value="{{ $item->qty }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="purchase_price[]" value="{{ $item->purchase_price }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="selling_price[]" value="{{ $item->selling_price }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="total[]" value="{{ $item->total }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Remove</a>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                <div class="text-end mt-5">
                    {{ html()->button('Update')->attribute('onclick', 'return validatePurchaseForm()')->class('btn btn-submit btn-primary') }}
                </div>
                {{ html()->form()->close() }}
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->attribute('id', 'purchaseForm')->class('')->open() }}
                                        <input type="hidden" name="type" value="purchase" />
                                        <div class="row g-3">
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Supplier </label>
                                                {{ html()->select('supplier_id', $suppliers,$purchase->supplier_id)->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Purchase Date</label>
                                                {{ html()->date('pdate', $purchase->pdate)->class('form-control') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Purchase Invoice</label>
                                                {{ html()->text('invoice', $purchase->invoice)->class('form-control')->placeholder('Invoice No.') }}
                                            </div>
                                            <div class="control-group col-md-12">
                                                <label class="form-label">Purchase Notes</label>
                                                {{ html()->text('notes', $purchase->notes)->class('form-control')->placeholder('Notes') }}
                                            </div>
                                        </div>
                                        {{ html()->form()->close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>Add New Item</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->attribute('id', 'purchaseItemForm')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Product </label>
                                                {{ html()->select('product_id', $products, old('product_id') ?? '')->class('select2 selPdct')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label">Batch Number</label>
                                                {{ html()->text('batch', '')->class('form-control')->placeholder('Batch Number') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label">Expiry Date</label>
                                                {{ html()->date('expiry', '')->class('form-control') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Qty</label>
                                                {{ html()->number('qty', '', '1', '', '1')->class('form-control')->placeholder('0') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Pur.Price</label>
                                                {{ html()->number('purchase_price', '', '1', '', 'any')->class('form-control')->placeholder('0.00') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Sell.Price</label>
                                                {{ html()->number('selling_price', '', '1', '', 'any')->class('form-control')->placeholder('0.00') }}
                                            </div>
                                        </div>
                                        <div class="raw text-end mt-3">
                                            <div class="col-md-12">
                                                {{ html()->button('Add')->attribute('type', 'button')->attribute('onClick', "return addItem('purchase')")->class('btn btn-primary') }}
                                            </div>
                                        </div>
                                        {{ html()->form()->close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection