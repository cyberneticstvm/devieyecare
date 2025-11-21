@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update User</h5>
        <p class="fs-12">Update User</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('user.update', encrypt($user->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-3">
                        <label class="form-label req">User Name </label>
                        {{ html()->text('name', $user->name)->class('form-control')->placeholder('User Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Email</label>
                        {{ html()->email('email', $user->email)->class('form-control')->placeholder('Email') }}
                        @error('email')
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Mobile Number</label>
                        {{ html()->text('mobile', $user->mobile)->maxlength(10)->class('form-control')->placeholder('Mobile Number') }}
                        @error('mobile')
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Password</label>
                        {{ html()->password('password', old('password') ?? '')->class('form-control')->placeholder('••••••••') }}
                        @error('password')
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Role</label>
                        {{ html()->select($name = 'roles', $value = $roles, $userRole)->class('select2 form-select')->placeholder('Select')->required() }}
                        @error('roles')
                        <small class="text-danger">{{ $errors->first('roles') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Branches <small>(Multiple selection enabled)</small></label>
                        {{ html()->select($name = 'branches[]', $value = $branches, $user->branches->pluck('branch_id'))->class('select2 form-control')->multiple()->required() }}
                        @error('branches')
                        <small class="text-danger">{{ $errors->first('branches') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Devices <small>(Multiple selection enabled)</small></label>
                        {{ html()->select($name = 'devices[]', $value = $devices, $user->devices->pluck('device_id'))->class('select2 form-control')->multiple()->required() }}
                        @error('devices')
                        <small class="text-danger">{{ $errors->first('devices') }}</small>
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