@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Camp Patient Register - {{ $camp->getCampName() }}</h5>
        <p class="fs-12">Showing camp patients</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Reg.Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Gender</th>
                            <th class="py-2 fw-medium small text-uppercase">Age</th>
                            <th class="py-2 fw-medium small text-uppercase">Mobile</th>
                            <th class="py-2 fw-medium small text-uppercase">Address</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $key => $patient)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $patient->registration_date->format('d.M.Y') }}</td>
                            <td><a href="{{ route('registration.create', ['rtype' => encrypt('Camp'), 'typeid' => encrypt($patient->id)]) }}" data-toggle="tooltip" data-placement="top" title="Click here to register the patient">{{ $patient->name }}</a></td>
                            <td>{{ $patient->gender }}</td>
                            <td>{{ $patient->age }}</td>
                            <td>{{ $patient->mobile }}</td>
                            <td>{{ $patient->address }}</td>
                            <td>{!! $patient->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('camp.patient.edit', encrypt($patient->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('camp.patient.delete', encrypt($patient->id)) }}" class="text-danger dlt">Delete</a>
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
                                <h5>New Patient</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('camp.patient.save')->class('')->open() }}
                                        <input type="hidden" name="camp_id" value="{{ encrypt($camp->id) }}" />
                                        <div class="row g-3">
                                            <div class="control-group col-md-5">
                                                <label class="form-label req">Reg. Date </label>
                                                {{ html()->date('registration_date', $camp->from_date->format('Y-m-d'))->class('form-control') }}
                                                @error('registration_date')
                                                <small class="text-danger">{{ $errors->first('registration_date') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-7">
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
                                            <div class="control-group col-md-5">
                                                <label class="form-label req">Address </label>
                                                {{ html()->text('address', old('address') ?? '')->class('form-control')->placeholder('Address') }}
                                                @error('address')
                                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Mobile </label>
                                                {{ html()->text('mobile', old('mobile') ?? '')->class('form-control')->maxlength(10)->placeholder('Mobile') }}
                                                @error('mobile')
                                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-8">
                                                <label class="form-label">Notes </label>
                                                {{ html()->text('notes', old('notes') ?? '')->class('form-control')->placeholder('Notes') }}
                                                @error('notes')
                                                <small class="text-danger">{{ $errors->first('notes') }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="raw mt-3">
                                            <div class="col text-end">
                                                {{ html()->submit('Save')->class('btn btn-submit btn-primary') }}
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
    </div>
</div>
@endsection