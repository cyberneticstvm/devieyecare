@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Dashboard</h5>
        <p class="fs-12">Showing interactive realtime dashboard</p>
    </div>
</div>
<div class="col-12 col-lg-3 col-md-6 col-sm-6">
    <div class="card rounded-4 overflow-hidden">
        <div class="card-body p-lg-4 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-body-secondary small">New Registrations</div>
                <div class="h3 mb-0">{{ getDataCount()[0] }}</div>
            </div>
            <div class="rounded p-3 bg-primary-subtle">
                <i class="bi bi-people fs-4 text-primary"></i>
            </div>
        </div>
        <!--<div class="card-footer px-lg-4 small text-success"><i class="bi bi-arrow-up-right"></i> +4.3% vs last week</div>-->
        <div class="card-footer px-lg-4 small text-success">Today's Data</div>
    </div>
</div>
<div class="col-12 col-lg-3 col-md-6 col-sm-6">
    <div class="card rounded-4 overflow-hidden">
        <div class="card-body p-lg-4 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-body-secondary small">Reviews</div>
                <div class="h3 mb-0">{{ getDataCount()[1] }}</div>
            </div>
            <div class="rounded p-3 bg-info-subtle">
                <i class="bi bi-arrow-left-right fs-4 text-info"></i>
            </div>
        </div>
        <!--<div class="card-footer px-lg-4 small text-success"><i class="bi bi-arrow-up-right"></i> +6 new this month</div>-->
        <div class="card-footer px-lg-4 small text-success">Today's Data</div>
    </div>
</div>
<div class="col-12 col-lg-3 col-md-6 col-sm-6">
    <div class="card rounded-4 overflow-hidden">
        <div class="card-body p-lg-4 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-body-secondary small">Orders</div>
                <div class="h3 mb-0">{{ getDataCount()[2] }}</div>
            </div>
            <div class="rounded p-3 bg-secondary-subtle">
                <i class="bi bi-eyeglasses fs-4 text-success"></i>
            </div>
        </div>
        <!--<div class="card-footer px-lg-4 small text-danger"><i class="bi bi-arrow-down-right"></i> -1.1% vs last month</div>-->
        <div class="card-footer px-lg-4 small text-success">Today's Data</div>
    </div>
</div>
<div class="col-12 col-lg-3 col-md-6 col-sm-6">
    <div class="card rounded-4 overflow-hidden">
        <div class="card-body p-lg-4 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-body-secondary small">Pharmacy Bills</div>
                <div class="h3 mb-0">{{ getDataCount()[3] }}</div>
            </div>
            <div class="rounded p-3 bg-warning-subtle">
                <i class="bi bi-prescription fs-4 text-warning"></i>
            </div>
        </div>
        <!--<div class="card-footer px-lg-4 small text-success"><i class="bi bi-arrow-up-right"></i> +0.2 this quarter</div>-->
        <div class="card-footer px-lg-4 small text-success">Today's Data</div>
    </div>
</div>
<div class="col-xl-8 col-lg-12">
    <div class="card rounded-4 mb-3">
        <div class="card-header p-lg-4 p-3 d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">Registrations & Orders - Last 12 Months</h6>
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
<div class="col-md-4">
    <div class="card rounded-4">
        <div class="card-body p-lg-4">
            <h5 class="card-title">Expenses Overview - Last 7 Days</h5>
            <div id="expenseChart"></div>
        </div>
    </div>
</div>
<div class="col-md-8">
    <div class="card rounded-4">
        <div class="card-body p-lg-4">
            <h5 class="card-title">Patient Reviews Overview - Last 30 Days</h5>
            <div id="reviewChart"></div>
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