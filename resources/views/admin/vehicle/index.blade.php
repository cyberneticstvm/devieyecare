@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Vehicle Register</h5>
        <p class="fs-12">Showing vehicles</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Reg. Number</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Mobile</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $key => $vehicle)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('vehicle.payment.list', encrypt($vehicle->id)) }}" data-toggle="tooltip" data-placement="top" title="Click here to make payment for this vehicle">{{ $vehicle->registration_number }}</a></td>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->mobile }}</td>
                            <td>{!! $vehicle->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('vehicle.edit', encrypt($vehicle->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('vehicle.delete', encrypt($vehicle->id)) }}" class="text-danger dlt">Delete</a>
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
                                <h5>New Vehicle</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('vehicle.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Owner Name </label>
                                                {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Owner Name') }}
                                                @error('name')
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Mobile </label>
                                                {{ html()->text('mobile', old('mobile') ?? '')->class('form-control')->maxlength(10)->placeholder('mobile') }}
                                                @error('mobile')
                                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Registration Number </label>
                                                {{ html()->text('registration_number', old('registration_number') ?? '')->class('form-control')->placeholder('Registration Number') }}
                                                @error('registration_number')
                                                <small class="text-danger">{{ $errors->first('registration_number') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Branch</label>
                                                {{ html()->select($name = 'branch_id', $value = $branches, old('branch_id'))->class('form-select')->placeholder('Select') }}
                                                @error('branch_id')
                                                <small class="text-danger">{{ $errors->first('branch_id') }}</small>
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