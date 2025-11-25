@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Camp</h5>
        <p class="fs-12">Update Camp</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('camp.update', encrypt($camp->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">From Date </label>
                        {{ html()->date('from_date', $camp->from_date->format('Y-m-d'))->class('form-control') }}
                        @error('from_date')
                        <small class="text-danger">{{ $errors->first('from_date') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">To Date </label>
                        {{ html()->date('to_date', $camp->to_date->format('Y-m-d'))->class('form-control') }}
                        @error('to_date')
                        <small class="text-danger">{{ $errors->first('to_date') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Venue </label>
                        {{ html()->text('venue', $camp->venue)->class('form-control')->placeholder('Venue') }}
                        @error('venue')
                        <small class="text-danger">{{ $errors->first('venue') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-5">
                        <label class="form-label req">Address </label>
                        {{ html()->text('address', $camp->address)->class('form-control')->placeholder('Address') }}
                        @error('address')
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Co-Ordinator </label>
                        {{ html()->text('coordinator', $camp->coordinator)->class('form-control')->placeholder('Co-Ordinator') }}
                        @error('coordinator')
                        <small class="text-danger">{{ $errors->first('coordinator') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Branch</label>
                        {{ html()->select($name = 'branch_id', $value = $branches, $camp->branch_id)->class('form-select')->placeholder('Select') }}
                        @error('branch_id')
                        <small class="text-danger">{{ $errors->first('branch_id') }}</small>
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