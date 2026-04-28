<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="customerAccountForm">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Customer Account Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pe-4">
        <div class="px-lg-2 mb-4">
            <div class="customerAccountForm">
                <div class="col-lg-12">
                    {{ html()->form('POST')->route('drishti.customer.save')->class('')->open() }}
                    <input type="hidden" name="customer_id" id="customer_id" value="">
                    <input type="hidden" name="payment_type" id="payment_type" value="credit">
                    <div class="row g-3">
                        <div class="control-group col-md-6">
                            <label class="form-label req">Amount</label>
                            {{ html()->number('amount', old('amount') ?? '')->class('form-control')->placeholder('Amount') }}
                            @error('amount')
                            <small class="text-danger">{{ $errors->first('amount') }}</small>
                            @enderror
                        </div>
                        <div class="control-group col-md-6">
                            <label class="form-label req">Payment Mode</label>
                            {{ html()->select('payment_mode', $pmodes, null)->class('form-control')->attribute('id', 'payment_mode')->placeholder('Payment Mode') }}
                            @error('payment_mode')
                            <small class="text-danger">{{ $errors->first('payment_mode') }}</small>
                            @enderror
                        </div>
                        <div class="control-group col-md-12">
                            <label class="form-label">Description </label>
                            {{ html()->text('description', old('description') ?? '')->class('form-control')->placeholder('Description') }}
                            @error('description')
                            <small class="text-danger">{{ $errors->first('description') }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="raw mt-3">
                        <div class="col text-end">
                            {{ html()->submit('Save')->class('btn btn-submit btn-primary') }}
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>
</div>