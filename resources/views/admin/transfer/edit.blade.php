@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Transfer</h5>
        <p class="fs-12">Update Transfer</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                {{ html()->form('POST')->route('transfer.update', encrypt($transfer->id))->attribute('id', 'transferItemsForm')->class('')->open() }}
                <table id="apptTable" class="table table-round align-middle mb-0 table-hover w-100 mt-2 border-top">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">Product</th>
                            <th class="py-2 fw-medium small text-uppercase">Batch</th>
                            <th class="py-2 fw-medium small text-uppercase">Qty</th>
                            <th class="py-2 fw-medium small text-uppercase">Remove</th>
                        </tr>
                    </thead>
                    <tbody class="transferItem">
                        @forelse($transfer->details as $key => $item)
                        <tr>
                            <td>
                                <input type="hidden" name="product_id[]" value="{{ $item->product->id }}" class="slctdPct"><input type="text" name="product[]" value="{{ $item->product->name }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="batch[]" value="{{ $item->batch }}" class="border-0 w-100" readonly>
                            </td>
                            <td>
                                <input type="text" name="qty[]" value="{{ $item->qty }}" class="border-0 w-100" readonly>
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
                    {{ html()->button('Update')->attribute('onclick', 'return validateTransferForm()')->class('btn btn-submit btn-primary') }}
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
                                        {{ html()->form('POST')->attribute('id', 'transferForm')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">From Branch </label>
                                                {{ html()->select('from_branch', $from_branches, $transfer->from_branch)->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">To Branch </label>
                                                {{ html()->select('to_branch', $to_branches, $transfer->to_branch)->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Transfer Date</label>
                                                {{ html()->date('tdate', $transfer->tdate)->class('form-control') }}
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label">Transfer Notes</label>
                                                {{ html()->text('notes', $transfer->notes)->class('form-control')->placeholder('Notes') }}
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
                                        {{ html()->form('POST')->attribute('id', 'transferItemForm')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Product </label>
                                                {{ html()->select('product_id', $products, old('product_id') ?? '')->class('select2 selPdct')->attribute('data-frm', 'transfer')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-8">
                                                <label class="form-label">Batch Number</label>
                                                {{ html()->select('batch', '')->class('select2 selBatch')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Qty</label>
                                                {{ html()->number('qty', '', '1', '', '1')->class('form-control')->placeholder('0') }}
                                            </div>
                                        </div>
                                        <div class="raw text-end mt-3">
                                            <div class="col-md-12">
                                                {{ html()->button('Add')->attribute('type', 'button')->attribute('onClick', "return addItem('transfer')")->class('btn btn-primary') }}
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