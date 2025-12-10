@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Payment</h5>
        <p class="fs-12">Update Payment</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('payment.update', encrypt($payment->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">Pay. Date </label>
                        {{ html()->date('pdate', $payment->pdate->format('Y-m-d'))->class('form-control') }}
                        @error('pdate')
                        <small class="text-danger">{{ $errors->first('pdate') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">MRN </label>
                        {{ html()->text('mrn', $payment->order->registration->mrn)->class('form-control')->placeholder('MRN') }}
                        @error('mrn')
                        <small class="text-danger">{{ $errors->first('mrn') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Order Type</label>
                        {{ html()->select($name = 'order_type', $value = $otypes, $payment->order_type)->class('form-select')->placeholder('Select') }}
                        @error('order_type')
                        <small class="text-danger">{{ $errors->first('order_type') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Payment Type</label>
                        {{ html()->select($name = 'payment_type', $value = $ptypes, $payment->payment_type)->class('form-select')->placeholder('Select') }}
                        @error('payment_type')
                        <small class="text-danger">{{ $errors->first('payment_type') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Amount</label>
                        {{ html()->number('amount', $payment->amount, '1', '', '1')->class('form-control')->placeholder('0.00') }}
                        @error('amount')
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Payment Mode</label>
                        {{ html()->select($name = 'pmode', $value = $pmodes, $payment->pmode)->class('form-select')->placeholder('Select') }}
                        @error('pmode')
                        <small class="text-danger">{{ $errors->first('pmode') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-6">
                        <label class="form-label">Notes </label>
                        {{ html()->text('notes', $payment->notes)->class('form-control')->placeholder('Notes') }}
                        @error('notes')
                        <small class="text-danger">{{ $errors->first('notes') }}</small>
                        @enderror
                    </div>
                </div>
                <div class="raw mt-3">
                    <div class="col text-end">
                        {{ html()->button('Cancel')->class('btn btn-secondary')->attribute('onclick', 'window.history.back()')->attribute('type', 'button') }}
                        {{ html()->submit('Update')->class('btn btn-submit btn-primary') }}
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
@endsection