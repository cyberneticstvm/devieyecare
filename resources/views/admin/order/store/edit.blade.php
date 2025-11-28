@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Store Order - {{ $registration->getMrn() }}</h5>
        <p class="fs-12">Store Order</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('order.update', $registration->id)->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">Patient Name </label>
                        {{ html()->text('name', $registration->name )->class('form-control')->attribute('readonly', true) }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Age </label>
                        {{ html()->text('age', $registration->age )->class('form-control')->attribute('readonly', true) }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Gender </label>
                        {{ html()->text('gender', $registration->gender )->class('form-control')->attribute('readonly', true) }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Mobile </label>
                        {{ html()->text('mobile', $registration->mobile )->class('form-control')->attribute('readonly', true) }}
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Address </label>
                        {{ html()->text('address', $registration->address )->class('form-control')->attribute('readonly', true) }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Doctor </label>
                        {{ html()->text('doctor', $registration->doctor->name )->class('form-control')->attribute('readonly', true) }}
                    </div>
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