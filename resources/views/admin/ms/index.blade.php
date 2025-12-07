@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">{{ $category }} Register</h5>
        <p class="fs-12">Showing {{ $category }} register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Mobile</th>
                            <th class="py-2 fw-medium small text-uppercase">Address</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mss as $key => $ms)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $ms->name }}</td>
                            <td>{{ $ms->mobile }}</td>
                            <td>{{ $ms->address }}</td>
                            <td>{!! $ms->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('ms.edit', ['category' => $category, 'id' => encrypt($ms->id)]) }}" class="text-secondary">Edit</a> | <a href="{{ route('ms.delete', ['category' => $category, 'id' => encrypt($ms->id)]) }}" class="text-danger dlt">Delete</a>
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
                                <h5>New {{ $category }}</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('ms.save', $category)->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Name </label>
                                                {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Name') }}
                                                @error('name')
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Mobile </label>
                                                {{ html()->text('mobile', old('mobile') ?? '')->class('form-control')->maxlength(10)->placeholder('Mobile') }}
                                                @error('mobile')
                                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Address </label>
                                                {{ html()->text('address', old('address') ?? '')->class('form-control')->placeholder('Address') }}
                                                @error('address')
                                                <small class="text-danger">{{ $errors->first('address') }}</small>
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