@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Camp</h5>
        <p class="fs-12">Update Camp</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('camp.patient.update', encrypt($patient->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">Reg. Date </label>
                        {{ html()->date('registration_date', $patient->registration_date->format('Y-m-d'))->class('form-control') }}
                        @error('registration_date')
                        <small class="text-danger">{{ $errors->first('registration_date') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Patient Name </label>
                        {{ html()->text('name', $patient->name)->class('form-control')->placeholder('Patient Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Age </label>
                        {{ html()->number('age', $patient->age, '', '', '')->class('form-control')->placeholder('0') }}
                        @error('age')
                        <small class="text-danger">{{ $errors->first('age') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Gender</label>
                        {{ html()->select($name = 'gender', $value = $gender, $patient->gender)->class('form-select')->placeholder('Select') }}
                        @error('gender')
                        <small class="text-danger">{{ $errors->first('gender') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Mobile </label>
                        {{ html()->text('mobile', $patient->mobile)->class('form-control')->maxlength(10)->placeholder('Mobile') }}
                        @error('mobile')
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Address </label>
                        {{ html()->text('address', $patient->address)->class('form-control')->placeholder('Address') }}
                        @error('address')
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-6">
                        <label class="form-label">Notes </label>
                        {{ html()->text('notes', $patient->notes)->class('form-control')->placeholder('Notes') }}
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