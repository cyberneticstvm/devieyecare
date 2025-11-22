@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Dashboard</h5>
        <p class="fs-12">Showing interactive realtime dashboard</p>
    </div>
</div>
@if(!Session::has('branch'))
<div class="modal-onboarding modal fade animate__animated" id="branchSelector" tabindex="-1"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{ html()->form('POST')->route('user.branch.update')->class('')->open() }}
            <div class="modal-body p-0">
                <div class="container row">
                    <div class="col">
                        <div class="control-group col-md-12">
                            <label for="roleEx3" class="form-label mt-3 req">Select Branch</label>
                            {{ html()->select($name = 'branch', $branches, old('branch'))->class('form-control')->placeholder('Select')->required() }}
                            @error('branch')
                            <small class="text-danger">{{ $errors->first('branch') }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-submit btn-primary">Update</button>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endif
@endsection