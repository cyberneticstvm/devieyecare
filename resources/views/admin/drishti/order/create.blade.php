@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Create Customer Order</h5>
        <p class="fs-12">New Customer Order</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                {{ html()->form('POST')->route('drishti.customer.order.save')->attribute('id', 'customerOrderForm')->class('')->open() }}
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
                    </tbody>
                </table>
                <div class="text-end mt-5">
                    {{ html()->button('Save')->attribute('onclick', 'return validatePurchaseForm()')->class('btn btn-submit btn-primary') }}
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
                                        <div class="row g-3">
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Customer </label>
                                                {{ html()->select('customer_id', $customers, old('customer_id') ?? '')->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-12">
                                                <label class="form-label">Order Notes</label>
                                                {{ html()->text('notes', old('notes') ?? '')->class('form-control')->placeholder('Notes') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Order Date</label>
                                                {{ html()->date('order_date', old('order_date') ?? date('Y-m-d'))->class('form-control') }}
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <label class="form-label">Show Price in DO </label><br>
                                                {{ html()->checkbox('show_price', false, 1)->class('form-check-input') }}
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
                                                {{ html()->select('product_id', $products, old('product_id') ?? '')->class('select2 selPdct')->attribute('data-frm', 'purchase')->placeholder('Select') }}
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
                                                <label class="form-label req">Sell.Price</label>
                                                {{ html()->number('selling_price', '', '1', '', 'any')->class('form-control')->placeholder('0.00') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <!--<label class="form-label req">Pur.Price</label>-->
                                                {{ html()->hidden('purchase_price', 0, 0, 0, 'any')->class('form-control')->placeholder('0.00') }}
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