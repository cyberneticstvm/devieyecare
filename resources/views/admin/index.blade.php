@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Dashboard</h5>
        <p class="fs-12">Showing interactive realtime dashboard</p>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="card rounded-4">
        <div class="card-body p-lg-4 d-flex justify-content-between">
            <div>
                <h6>Registration</h6>
                <h4>{{ getDataCount()[0] }}</h4>
            </div>
            <span class="badge bg-danger align-self-start">Today</span>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="card rounded-4">
        <div class="card-body p-lg-4 d-flex justify-content-between">
            <div>
                <h6>Review</h6>
                <h4>{{ getDataCount()[1] }}</h4>
            </div>
            <span class="badge bg-warning text-dark align-self-start">Today</span>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="card rounded-4">
        <div class="card-body p-lg-4 d-flex justify-content-between">
            <div>
                <h6>Order</h6>
                <h4>{{ getDataCount()[2] }}</h4>
            </div>
            <span class="badge bg-info text-dark align-self-start">Today</span>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="card rounded-4">
        <div class="card-body p-lg-4 d-flex justify-content-between">
            <div>
                <h6>Pharmacy</h6>
                <h4>{{ getDataCount()[3] }}</h4>
            </div>
            <span class="badge bg-primary text-dark align-self-start">Today</span>
        </div>
    </div>
</div>
<div class="col-xl-8 col-lg-12">
    <div class="card rounded-4 mb-3">
        <div class="card-header p-lg-4 p-3 d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">Registrations & Orders</h6>
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></a>
                <ul class="dropdown-menu shadow li_animate">
                    <li><a class="dropdown-item" href="#">12 Months</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-lg-4 p-3">
            <div id="apex-chart-line-column" style="height: 240px;"></div>
        </div>
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