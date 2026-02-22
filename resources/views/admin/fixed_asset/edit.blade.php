@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update Fixed Asset</h5>
        <p class="fs-12">Update Fixed Asset</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('fa.update', encrypt($fa->id))->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-8">
                        <label class="form-label req">Asset Name </label>
                        {{ html()->text('name', $fa->name)->class('form-control')->placeholder('Asset Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Qty </label>
                        {{ html()->number('qty', $fa->qty, '1', '', '1')->class('form-control')->placeholder('0') }}
                        @error('amount')
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-6">
                        <label class="form-label req">Branch</label>
                        {{ html()->select('branch_id', $value = $branches, $fa->branch_id)->class('form-control')->placeholder('Select')->required() }}
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