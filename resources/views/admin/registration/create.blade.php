@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Create New Registration</h5>
        <p class="fs-12">Create New Registration</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('registration.save', ['rtype' => $rtype, 'typeid' => $typeid])->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-4">
                        <label class="form-label req">Patient Name </label>
                        {{ html()->text('name', $patient?->name ?? old('name'))->class('form-control')->placeholder('Patient Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Age </label>
                        {{ html()->number('age', $patient?->age ?? old('age'), '', '', '')->class('form-control')->placeholder('0') }}
                        @error('age')
                        <small class="text-danger">{{ $errors->first('age') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Gender</label>
                        {{ html()->select($name = 'gender', $value = $gender, $patient?->gender ?? old('gender'))->class('form-select')->placeholder('Select') }}
                        @error('gender')
                        <small class="text-danger">{{ $errors->first('gender') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Address </label>
                        {{ html()->text('address', $patient?->address ?? old('address'))->class('form-control')->placeholder('Address') }}
                        @error('address')
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Mobile </label>
                        {{ html()->text('mobile', $patient?->mobile ?? old('mobile'))->class('form-control')->maxlength(10)->placeholder('Mobile') }}
                        @error('mobile')
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Doctor</label>
                        {{ html()->select($name = 'doctor_id', $value = $doctors, $patient?->doctor_id ?? old('doctor_id'))->class('form-select')->placeholder('Select') }}
                        @error('doctor_id')
                        <small class="text-danger">{{ $errors->first('doctor_id') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Consultation Type</label>
                        {{ html()->select($name = 'ctype', $value = $ctypes, old('ctype') ?? '')->class('form-select')->placeholder('Select') }}
                        @error('ctype')
                        <small class="text-danger">{{ $errors->first('ctype') }}</small>
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