@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Camp Register</h5>
        <p class="fs-12">Showing camps • Local time zone</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Camp</th>
                            <th class="py-2 fw-medium small text-uppercase">From</th>
                            <th class="py-2 fw-medium small text-uppercase">To</th>
                            <th class="py-2 fw-medium small text-uppercase">Venue</th>
                            <th class="py-2 fw-medium small text-uppercase">Co-ordinator</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($camps as $key => $camp)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('camp.patient.list', encrypt($camp->id)) }}" data-toggle="tooltip" data-placement="top" title="Click here to register the patient under this camp">{{ $camp->getCampName() }}</a></td>
                            <td>{{ $camp->from_date->format('d.M.Y') }}</td>
                            <td>{{ $camp->to_date->format('d.M.Y') }}</td>
                            <td>{{ $camp->venue }}</td>
                            <td>{{ $camp->coordinator }}</td>
                            <td>{!! $camp->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('camp.edit', encrypt($camp->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('camp.delete', encrypt($camp->id)) }}" class="text-danger dlt">Delete</a>
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
                                <h5>New Camp</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('camp.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">From Date </label>
                                                {{ html()->date('from_date', old('from_date') ?? date('Y-m-d'))->class('form-control') }}
                                                @error('from_date')
                                                <small class="text-danger">{{ $errors->first('from_date') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">To Date </label>
                                                {{ html()->date('to_date', old('to_date') ?? date('Y-m-d'))->class('form-control') }}
                                                @error('to_date')
                                                <small class="text-danger">{{ $errors->first('to_date') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-5">
                                                <label class="form-label req">Venue </label>
                                                {{ html()->text('venue', old('venue') ?? '')->class('form-control')->placeholder('Venue') }}
                                                @error('venue')
                                                <small class="text-danger">{{ $errors->first('venue') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-7">
                                                <label class="form-label req">Address </label>
                                                {{ html()->text('address', old('address') ?? '')->class('form-control')->placeholder('Address') }}
                                                @error('address')
                                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Co-Ordinator </label>
                                                {{ html()->text('coordinator', old('coordinator') ?? '')->class('form-control')->placeholder('Co-Ordinator') }}
                                                @error('coordinator')
                                                <small class="text-danger">{{ $errors->first('coordinator') }}</small>
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