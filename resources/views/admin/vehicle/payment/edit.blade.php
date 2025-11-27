@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Vehicle Payment</h5>
        <p class="fs-12">Update Vehicle Payment</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('vehicle.payment.update', encrypt($payment->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">Payment Date </label>
                        {{ html()->date('pdate', $payment->pdate->format('Y-m-d'))->class('form-control') }}
                        @error('pdate')
                        <small class="text-danger">{{ $errors->first('pdate') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Amount </label>
                        {{ html()->number('amount', $payment->amount, '1', '', '')->class('form-control')->placeholder('0.00') }}
                        @error('amount')
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
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