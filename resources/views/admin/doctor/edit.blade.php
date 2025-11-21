@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Doctor</h5>
        <p class="fs-12">Update Doctor</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('doctor.update', encrypt($doctor->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-3">
                        <label class="form-label req">Doctor Name </label>
                        {{ html()->text('name', $doctor->name)->class('form-control')->placeholder('Doctor Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Code </label>
                        {{ html()->text('code', $doctor->code)->maxlength(10)->class('form-control')->placeholder('Doctor Code') }}
                        @error('code')
                        <small class="text-danger">{{ $errors->first('code') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Qualification </label>
                        {{ html()->text('qualification', $doctor->qualification)->class('form-control')->placeholder('Qualification') }}
                        @error('qualification')
                        <small class="text-danger">{{ $errors->first('qualification') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Email</label>
                        {{ html()->email('email', $doctor->email)->class('form-control')->placeholder('Email') }}
                        @error('email')
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Mobile Number</label>
                        {{ html()->text('mobile', $doctor->mobile)->maxlength(10)->class('form-control')->placeholder('Mobile Number') }}
                        @error('mobile')
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label">Address</label>
                        {{ html()->text('address', $doctor->address)->class('form-control')->placeholder('Address') }}
                        @error('address')
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Fee</label>
                        {{ html()->number('fee', $doctor->fee, '0', '', '1')->class('form-control')->placeholder('0.00') }}
                        @error('fee')
                        <small class="text-danger">{{ $errors->first('fee') }}</small>
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