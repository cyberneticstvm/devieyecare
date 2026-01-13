@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Create Role</h5>
        <p class="fs-12">Create New Role</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('role.save')->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-3">
                        <label class="form-label req">Role Name </label>
                        {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Role Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12"><label class="form-label req" for="basicFullname">Permissions</label></div>
                    @foreach($permissions as $permission)
                    <div class="col-sm-2">
                        <label class="form-check-label" for="">{{ $permission->name }}</label><br />
                        {{ html()->checkbox($name = 'permission[]', $checked=false, $value = $permission->id)->class('form-check-input') }}
                    </div>
                    @endforeach
                    @error('permission')
                    <small class="text-danger">{{ $errors->first('permission') }}</small>
                    @enderror
                </div>
                <div class="raw mt-3">
                    <div class="col text-end">
                        {{ html()->button('Cancel')->class('btn btn-secondary')->attribute('onclick', 'window.history.back()')->attribute('type', 'button') }}
                        {{ html()->submit('Save')->class('btn btn-submit btn-primary') }}
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
@endsection