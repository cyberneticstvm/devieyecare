@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Settings</h5>
        <p class="fs-12">Settings</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12 col-md-3 col-sm-6">
                <div class="card rounded-4">
                    <div class="card-body p-lg-4">
                        <h5>Settings</h5>
                        <div class="row g-lg-12 g-3">
                            <div class="col-lg-12">
                                {{ html()->form('POST')->route('settings.save')->class('')->open() }}
                                <div class="row g-3">
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Consulation Fee Waived Days </label>
                                        {{ html()->number('consultation_fee_waived_days', $settings->consultation_fee_waived_days, '1', '', '1')->class('form-control')->placeholder('0') }}
                                        @error('consultation_fee_waived_days')
                                        <small class="text-danger">{{ $errors->first('consultation_fee_waived_days') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Consulation Fee Waived Days Surgery</label>
                                        {{ html()->number('consultation_fee_waived_days_for_surgery', $settings->consultation_fee_waived_days_for_surgery, '1', '', '1')->class('form-control')->placeholder('0') }}
                                        @error('consultation_fee_waived_days_for_surgery')
                                        <small class="text-danger">{{ $errors->first('consultation_fee_waived_days_for_surgery') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Vehicle Fee / Month</label>
                                        {{ html()->number('vehicle_fee_per_month', $settings->vehicle_fee_per_month, '1', '', '1')->class('form-control')->placeholder('0') }}
                                        @error('vehicle_fee_per_month')
                                        <small class="text-danger">{{ $errors->first('vehicle_fee_per_month') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Pdct.Advisor.Commission</label>
                                        {{ html()->number('pdct_advisor_commission_level', $settings->pdct_advisor_commission_level, '1', '', '1')->class('form-control')->placeholder('0') }}
                                        @error('pdct_advisor_commission_level')
                                        <small class="text-danger">{{ $errors->first('pdct_advisor_commission_level') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Inv. Due. Amount Limit</label>
                                        {{ html()->number('invoice_due_amount_limit', $settings->invoice_due_amount_limit, '1', '', '1')->class('form-control')->placeholder('0') }}
                                        @error('invoice_due_amount_limit')
                                        <small class="text-danger">{{ $errors->first('invoice_due_amount_limit') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Inv. Due. Count Limit</label>
                                        {{ html()->number('invoice_due_count_limit', $settings->invoice_due_count_limit, '1', '', '1')->class('form-control')->placeholder('0') }}
                                        @error('invoice_due_count_limit')
                                        <small class="text-danger">{{ $errors->first('invoice_due_count_limit') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Login Allowed From</label>
                                        {{ html()->time('user_login_allowed_time_from', $settings->user_login_allowed_time_from)->class('form-control')->placeholder('0') }}
                                        @error('user_login_allowed_time_from')
                                        <small class="text-danger">{{ $errors->first('user_login_allowed_time_from') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">Login Allowed To</label>
                                        {{ html()->time('user_login_allowed_time_to', $settings->user_login_allowed_time_to)->class('form-control')->placeholder('0') }}
                                        @error('user_login_allowed_time_to')
                                        <small class="text-danger">{{ $errors->first('user_login_allowed_time_to') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">User Active Allowed From</label>
                                        {{ html()->time('user_active_time_from', $settings->user_active_time_from)->class('form-control')->placeholder('0') }}
                                        @error('user_active_time_from')
                                        <small class="text-danger">{{ $errors->first('user_active_time_from') }}</small>
                                        @enderror
                                    </div>
                                    <div class="control-group col-md-2">
                                        <label class="form-label req">User Active Allowed To</label>
                                        {{ html()->time('user_active_time_to', $settings->user_active_time_to)->class('form-control')->placeholder('0') }}
                                        @error('user_active_time_to')
                                        <small class="text-danger">{{ $errors->first('user_active_time_to') }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="raw mt-3">
                                    <div class="col text-end">
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
</div>
@endsection