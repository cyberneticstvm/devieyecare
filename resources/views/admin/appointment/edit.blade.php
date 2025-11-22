@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Appointment</h5>
        <p class="fs-12">Update Appointment</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('appointment.update', encrypt($appointment->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-4">
                        <label class="form-label req">Patient Name </label>
                        {{ html()->text('name', $appointment->name)->class('form-control')->placeholder('Patient Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Age </label>
                        {{ html()->number('age', $appointment->age, '', '', '')->class('form-control')->placeholder('0') }}
                        @error('age')
                        <small class="text-danger">{{ $errors->first('age') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Gender</label>
                        {{ html()->select($name = 'gender', $value = $gender, $appointment->gender)->class('form-select')->placeholder('Select') }}
                        @error('gender')
                        <small class="text-danger">{{ $errors->first('gender') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Address </label>
                        {{ html()->text('address', $appointment->address)->class('form-control')->placeholder('Address') }}
                        @error('address')
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Mobile </label>
                        {{ html()->text('mobile', $appointment->mobile)->class('form-control')->maxlength(10)->placeholder('Mobile') }}
                        @error('mobile')
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Branch</label>
                        {{ html()->select($name = 'branch_id', $value = $branches, $appointment->branch_id)->class('form-select')->placeholder('Select') }}
                        @error('branch_id')
                        <small class="text-danger">{{ $errors->first('branch_id') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Doctor</label>
                        {{ html()->select($name = 'doctor_id', $value = $doctors, $appointment->doctor_id)->class('form-select')->placeholder('Select') }}
                        @error('doctor_id')
                        <small class="text-danger">{{ $errors->first('doctor_id') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Appointment Date </label>
                        {{ html()->date('adate', $appointment->adate)->class('form-control') }}
                        @error('adate')
                        <small class="text-danger">{{ $errors->first('adate') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Appointment Time </label>
                        {{ html()->time('atime', $appointment->atime)->class('form-control') }}
                        @error('atime')
                        <small class="text-danger">{{ $errors->first('atime') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Old MRN </label>
                        {{ html()->text('old_mrn', $appointment->old_mrn)->class('form-control')->placeholder('Old MRN') }}
                        @error('old_mrn')
                        <small class="text-danger">{{ $errors->first('old_mrn') }}</small>
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