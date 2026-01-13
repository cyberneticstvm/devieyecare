@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Create Banch</h5>
        <p class="fs-12">Create New Branch</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('branch.save')->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-3">
                        <label class="form-label req">Branch Name </label>
                        {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Branch Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Branch Code </label>
                        {{ html()->text('code', old('code') ?? '')->maxlength(5)->class('form-control')->placeholder('Branch Code') }}
                        @error('code')
                        <small class="text-danger">{{ $errors->first('code') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label">Email</label>
                        {{ html()->email('email', old('email') ?? '')->class('form-control')->placeholder('Email') }}
                        @error('email')
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Contact Number</label>
                        {{ html()->text('contact', old('contact') ?? '')->class('form-control')->placeholder('Contact Number') }}
                        @error('contact')
                        <small class="text-danger">{{ $errors->first('contact') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">GSTIN</label>
                        {{ html()->text('gstin', old('gstin') ?? '')->class('form-control')->placeholder('GSTIN') }}
                        @error('gstin')
                        <small class="text-danger">{{ $errors->first('gstin') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label">Address</label>
                        {{ html()->text('address', old('address') ?? '')->class('form-control')->placeholder('Address') }}
                        @error('address')
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Display Capacity</label>
                        {{ html()->number('display_capacity', old('display_capacity') ?? '', '', '', 'any')->class('form-control')->placeholder('0') }}
                        @error('display_capacity')
                        <small class="text-danger">{{ $errors->first('display_capacity') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Invoice Starts With</label>
                        {{ html()->number('invoice_starts_with', old('invoice_starts_with') ?? '', '', '', 'any')->class('form-control')->placeholder('0') }}
                        @error('invoice_starts_with')
                        <small class="text-danger">{{ $errors->first('invoice_starts_with') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Daily Expense Limit</label>
                        {{ html()->number('daily_expense_limit', old('daily_expense_limit') ?? '', '', '', 'any')->class('form-control')->placeholder('0.00') }}
                        @error('daily_expense_limit')
                        <small class="text-danger">{{ $errors->first('daily_expense_limit') }}</small>
                        @enderror
                    </div>
                </div>
                <div class="raw mt-3">
                    <div class="col text-end">
                        {{ html()->button('Cancel')->class('btn btn-secondary')->attribute('onclick', 'window.history.back()')->attribute('type', 'button') }}
                        {{ html()->submit('Save')->class('btn btn-submit btn-primary') }}
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
@endsection