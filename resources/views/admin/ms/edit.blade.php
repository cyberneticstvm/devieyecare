@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Update {{ $category }}</h5>
        <p class="fs-12">Update {{ $category }}</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('ms.update', ['category' => $category, 'id' => encrypt($ms->id)])->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-4">
                        <label class="form-label req">Name </label>
                        {{ html()->text('name', $ms->name)->class('form-control')->placeholder('Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Mobile </label>
                        {{ html()->text('mobile', $ms->mobile)->class('form-control')->maxlength(10)->placeholder('Mobile') }}
                        @error('mobile')
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-4">
                        <label class="form-label req">Address </label>
                        {{ html()->text('address', $ms->address)->class('form-control')->placeholder('Address') }}
                        @error('address')
                        <small class="text-danger">{{ $errors->first('address') }}</small>
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