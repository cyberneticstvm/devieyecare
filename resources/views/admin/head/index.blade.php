@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Head Register</h5>
        <p class="fs-12">Showing head register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Head</th>
                            <th class="py-2 fw-medium small text-uppercase">Category</th>
                            <th class="py-2 fw-medium small text-uppercase">Description</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heads as $key => $head)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $head->name }}</td>
                            <td>{{ $head->category->name }}</td>
                            <td>{{ $head->description }}</td>
                            <td>{!! $head->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('head.edit', encrypt($head->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('head.delete', encrypt($head->id)) }}" class="text-danger dlt">Delete</a>
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
                                <h5>New Head</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('head.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-12">
                                                <label class="form-label req">Head Name </label>
                                                {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Head Name') }}
                                                @error('name')
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Category</label>
                                                {{ html()->select('category_id', $value = $categories, old('category_id'))->class('form-control')->placeholder('Select')->required() }}
                                                @error('category_id')
                                                <small class="text-danger">{{ $errors->first('category_id') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label">Description </label>
                                                {{ html()->text('description', old('description') ?? '')->class('form-control')->placeholder('Description') }}
                                                @error('description')
                                                <small class="text-danger">{{ $errors->first('description') }}</small>
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