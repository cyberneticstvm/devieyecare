@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update {{ $category->name }}</h5>
        <p class="fs-12">Update {{ $category->name }}</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('ie.update', ['category' => 'Expense', 'id' => encrypt($ie->id)])->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">Date </label>
                        {{ html()->date('ie_date', $ie->ie_date->format('Y-m-d'))->class('form-control') }}
                        @error('ie_date')
                        <small class="text-danger">{{ $errors->first('ie_date') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Head</label>
                        {{ html()->select('head_id', $heads, $ie->head_id)->class('form-control')->placeholder('Select')->required() }}
                        @error('head_id')
                        <small class="text-danger">{{ $errors->first('head_id') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Amount </label>
                        {{ html()->number('amount', $ie->amount, '1', '', '1')->class('form-control')->placeholder('0.00') }}
                        @error('amount')
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label">Description </label>
                        {{ html()->text('description', $ie->description)->class('form-control')->placeholder('Description') }}
                        @error('description')
                        <small class="text-danger">{{ $errors->first('description') }}</small>
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