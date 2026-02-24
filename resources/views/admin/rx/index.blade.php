@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Rx Stock Register</h5>
        <p class="fs-12">Showing Rx Stock register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Material</th>
                            <th class="py-2 fw-medium small text-uppercase">Sph</th>
                            <th class="py-2 fw-medium small text-uppercase">Cyl</th>
                            <th class="py-2 fw-medium small text-uppercase">Axis</th>
                            <th class="py-2 fw-medium small text-uppercase">Add.</th>
                            <th class="py-2 fw-medium small text-uppercase">Qty.</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rxstock as $key => $rx)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $rx->material->name }}</td>
                            <td>{{ $rx->sph }}</td>
                            <td>{{ $rx->cyl }}</td>
                            <td>{{ $rx->axis }}</td>
                            <td>{{ $rx->addition }}</td>
                            <td>{{ $rx->qty }}</td>
                            <td>{!! $rx->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('rx.delete', encrypt($rx->id)) }}" class="text-danger dlt">Delete</a>
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
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('rx.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Material Name </label>
                                                {{ html()->select('material_id', $materials, old('material_id'))->class('form-control')->placeholder('Select') }}
                                                @error('material_id')
                                                <small class="text-danger">{{ $errors->first('material_id') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">Sph </label>
                                                {{ html()->select('sph', $extras->where('category', 'sph')->pluck('name', 'name'), old('sph'))->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">Cyl </label>
                                                {{ html()->select('cyl', $extras->where('category', 'cyl')->pluck('name', 'name'), old('cyl'))->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">Axis </label>
                                                {{ html()->select('axis', $axis, old('axis'))->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">Add. </label>
                                                {{ html()->select('addition', $extras->where('category', 'addition')->pluck('name', 'name'), old('addition'))->class('select2')->placeholder('Select') }}
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">Qty. </label>
                                                {{ html()->number('qty')->class("form-control")->placeholder('0') }}
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