@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Create Pharmacy Order - {{ $registration->getMrn() }}</h5>
        <p class="fs-12">New Pharmacy Order</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                {{ html()->form('POST')->route((!$order) ? 'pharmacy.order.save' : 'pharmacy.order.update', encrypt($order->id ?? 0))->attribute('id', 'pharmacyItemsForm')->class('')->open() }}
                <input type="hidden" name="branch_id" value="{{ Session::get('branch')->id }}" />
                <input type="hidden" name="registration_id" value="{{ encrypt($registration->id) }}" />
                <table class="table table-round align-middle mb-0 table-hover w-100 mt-2 border-top">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">Product</th>
                            <th class="py-2 fw-medium small text-uppercase">Batch</th>
                            <th class="py-2 fw-medium small text-uppercase">Expiry</th>
                            <th class="py-2 fw-medium small text-uppercase">Qty</th>
                            <th class="py-2 fw-medium small text-uppercase">Price</th>
                            <th class="py-2 fw-medium small text-uppercase">Total</th>
                            <th class="py-2 fw-medium small text-uppercase">Remove</th>
                        </tr>
                    </thead>
                    <tbody class="pharmacyItem">
                        @if($order)
                        @forelse($order?->details as $key => $item)
                        <tr>
                            <td>
                                <input type="hidden" name="product_id[]" value="{{ $item->product_id }}" class="slctdPct">
                                <input type="text" name="product[]" value="{{ $item->product->name }}" class="border-0 w-100" />
                            </td>
                            <td><input type="text" name="batch[]" value="{{ $item->batch }}" class="border-0 w-100" /></td>
                            <td><input type="text" name="expiry[]" value="{{ $item->expiry }}" class="border-0 w-100" /></td>
                            <td><input type="text" name="qty[]" value="{{ $item->qty }}" class="border-0 w-100" /></td>
                            <td><input type="text" name="price[]" value="{{ $item->price }}" class="border-0 w-100" /></td>
                            <td><input type="text" name="total[]" value="{{ $item->total }}" class="border-0 w-100" /></td>
                            <td><a href="javascript:void(0)" onclick="$(this).parent().parent().remove()">Remove</a></td>
                        </tr>
                        @empty
                        @endforelse
                        @endif
                    </tbody>
                </table>
                <div class="row mt-5">
                    <div class="control-group col-md-4">
                        <label class="form-label">Discount if any</label>
                        {{ html()->number('discount', $order?->discount ?? '', '0', '', '')->class('form-control')->placeholder('0.00') }}
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Payment Mode</label>
                        {{ html()->select('pmode', $pmodes, $order?->pmode ?? '')->class('form-control')->placeholder('Select') }}
                    </div>
                </div>
                <div class="text-end mt-5">
                    {{ html()->button($order?->exists() ? 'Update' : 'Save')->attribute('onclick', 'return validatePharmacyForm()')->class('btn btn-submit btn-primary') }}
                </div>
                {{ html()->form()->close() }}
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>Add New Item</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('payment.save')->attribute('id', 'transferForm')->class('')->open() }}
                                        <input type="hidden" name="from_branch" value="{{ Session::get('branch')->id }}" />
                                        <div class="row g-3">
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Product </label>
                                                {{ html()->select('product_id', $products, old('product_id') ?? '')->class('select2 selPdct')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-8">
                                                <label class="form-label req">Batch </label>
                                                {{ html()->select('batch', '')->class('select2 selBatch')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Qty</label>
                                                {{ html()->number('qty', '', '1', '', '1')->class('form-control')->placeholder('0') }}
                                            </div>
                                        </div>
                                        <div class="raw text-end mt-3">
                                            <div class="col-md-12">
                                                {{ html()->button('Add')->attribute('type', 'button')->class('btn btn-primary addButton')->attribute('onClick', "return validatePharmacyItem()") }}
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