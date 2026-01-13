@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Appointment Register</h5>
        <p class="fs-12">Showing appointments • Local time zone</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Time</th>
                            <th class="py-2 fw-medium small text-uppercase">Patient</th>
                            <th class="py-2 fw-medium small text-uppercase">Doctor</th>
                            <th class="py-2 fw-medium small text-uppercase">Branch</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $key => $appointment)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $appointment->adate->format('d.M.Y') }}</td>
                            <td>{{ $appointment->atime->format('H:i a') }}</td>
                            <td><a href="{{ route('registration.create', ['rtype' => encrypt('Appointment'), 'typeid' => encrypt($appointment->id)]) }}" data-toggle="tooltip" data-placement="top" title="Click here to register the patient">{{ $appointment->name }}</a></td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->branch->name }}</td>
                            <td>{!! $appointment->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('appointment.edit', encrypt($appointment->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('appointment.delete', encrypt($appointment->id)) }}" class="text-danger dlt">Delete</a>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>New Appointment</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('appointment.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-9">
                                                <label class="form-label req">Patient Name </label>
                                                {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Patient Name') }}
                                                @error('name')
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-3">
                                                <label class="form-label req">Age </label>
                                                {{ html()->number('age', old('age') ?? '', '', '', '')->class('form-control')->placeholder('0') }}
                                                @error('age')
                                                <small class="text-danger">{{ $errors->first('age') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Gender</label>
                                                {{ html()->select($name = 'gender', $value = $gender, old('gender'))->class('form-select')->placeholder('Select') }}
                                                @error('gender')
                                                <small class="text-danger">{{ $errors->first('gender') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-8">
                                                <label class="form-label req">Address </label>
                                                {{ html()->text('address', old('address') ?? '')->class('form-control')->placeholder('Address') }}
                                                @error('address')
                                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Mobile </label>
                                                {{ html()->text('mobile', old('mobile') ?? '')->class('form-control')->maxlength(10)->placeholder('Mobile') }}
                                                @error('mobile')
                                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Branch</label>
                                                {{ html()->select($name = 'branch_id', $value = $branches, old('branch_id'))->class('form-select')->placeholder('Select') }}
                                                @error('branch_id')
                                                <small class="text-danger">{{ $errors->first('branch_id') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Doctor</label>
                                                {{ html()->select($name = 'doctor_id', $value = $doctors, old('doctor_id'))->class('form-select')->placeholder('Select') }}
                                                @error('doctor_id')
                                                <small class="text-danger">{{ $errors->first('doctor_id') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Appointment Date </label>
                                                {{ html()->date('adate', old('adate') ?? date('Y-m-d'))->class('form-control') }}
                                                @error('adate')
                                                <small class="text-danger">{{ $errors->first('adate') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Appointment Time </label>
                                                {{ html()->time('atime', old('atime'))->class('form-control') }}
                                                @error('atime')
                                                <small class="text-danger">{{ $errors->first('atime') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label">Old MRN </label>
                                                {{ html()->text('old_mrn', old('old_mrn') ?? '')->class('form-control')->placeholder('Old MRN') }}
                                                @error('old_mrn')
                                                <small class="text-danger">{{ $errors->first('old_mrn') }}</small>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection