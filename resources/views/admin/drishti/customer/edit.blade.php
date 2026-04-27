@extends('admin.base')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Customer</h3>
                </div>
                <div class="card-body">
                    <div class="row g-lg-12 g-3">
                        <div class="col-lg-12">
                            {{ html()->form('PUT')->route('drishti.customer.update', encrypt($customer->id))->class('')->open() }}
                            <div class="row g-3">
                                <div class="control-group col-md-3">
                                    <label class="form-label req">Customer Name </label>
                                    {{ html()->text('name', old('name') ?? $customer->name)->class('form-control')->placeholder('Customer Name') }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="control-group col-md-2">
                                    <label class="form-label req">Contact Number </label>
                                    {{ html()->text('mobile', old('mobile') ?? $customer->mobile)->class('form-control')->maxlength(10)->placeholder('Contact Number') }}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="control-group col-md-5">
                                    <label class="form-label">Address </label>
                                    {{ html()->text('address', old('address') ?? $customer->address)->class('form-control')->placeholder('Address') }}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                                <div class="control-group col-md-2">
                                    <label class="form-label">GST Number </label>
                                    {{ html()->text('gst', old('gst') ?? $customer->gst)->class('form-control')->placeholder('GST Number') }}
                                    @error('gst')
                                    <small class="text-danger">{{ $errors->first('gst') }}</small>
                                    @enderror
                                </div>
                                <div class="control-group col-md-2">
                                    <label class="form-label">Opening Balance </label>
                                    {{ html()->text('opening_balance', old('opening_balance') ?? $customer->opening_balance)->class('form-control')->placeholder('Opening Balance') }}
                                    @error('opening_balance')
                                    <small class="text-danger">{{ $errors->first('opening_balance') }}</small>
                                    @enderror
                                </div>
                                <div class="control-group col-md-2">
                                    <label class="form-label">Credit Limit </label>
                                    {{ html()->text('credit_limit', old('credit_limit') ?? $customer->credit_limit)->class('form-control')->placeholder('Credit Limit') }}
                                    @error('credit_limit')
                                    <small class="text-danger">{{ $errors->first('credit_limit') }}</small>
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
        </div>
    </div>
</div>
@endsection