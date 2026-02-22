@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Fixed Asset Register</h5>
        <p class="fs-12">Showing Fixed Asset register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Asset</th>
                            <th class="py-2 fw-medium small text-uppercase">Qty</th>
                            <th class="py-2 fw-medium small text-uppercase">Branch</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fas as $key => $fa)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $fa->created_at->format("d.M.Y") }}</td>
                            <td>{{ $fa->name }}</td>
                            <td>{{ $fa->qty }}</td>
                            <td>{{ $fa->branch->name }}</td>
                            <td>{!! $fa->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('fa.edit', encrypt($fa->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('fa.delete', encrypt($fa->id)) }}" class="text-danger dlt">Delete</a>
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
                                <h5>New Asset</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('fa.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-8">
                                                <label class="form-label req">Asset Name </label>
                                                {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Asset Name') }}
                                                @error('name')
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label req">Qty </label>
                                                {{ html()->number('qty', old('qty') ?? '', '1', '', '1')->class('form-control')->placeholder('0') }}
                                                @error('amount')
                                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Branch</label>
                                                {{ html()->select('branch_id', $value = $branches, old('branch_id'))->class('form-control')->placeholder('Select')->required() }}
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