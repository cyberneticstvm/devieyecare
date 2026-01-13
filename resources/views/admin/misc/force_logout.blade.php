@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">User Forced Logout</h5>
        <p class="fs-12">User Forced Logout from All Devices Except Current</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-6">
                {{ html()->form('POST')->route('force.logout.all')->class('d-flex')->attribute('role', 'search')->open() }}
                {{ html()->password('password', '')->class('form-control me-2')->class('form-control me-2')->attribute('id', 'navbarSearch')->placeholder('Current Password') }}
                {{ html()->submit('Force Logout')->class('btn btn-submit btn-primary w-100') }}
                {{ html()->form()->close() }}
                @error('password')
                <small class="text-danger">{{ $errors->first('password') }}</small>
                @enderror
            </div>
        </div>
    </div>
</div>
@endsection