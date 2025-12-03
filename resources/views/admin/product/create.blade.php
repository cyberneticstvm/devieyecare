@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Create New Product</h5>
        <p class="fs-12">Create New Product</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('product.save')->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-4">
                        <label class="form-label req">Product Name </label>
                        {{ html()->text('name', old('name'))->class('form-control')->placeholder('Product Name') }}
                        @error('name')
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Category</label>
                        {{ html()->select($name = 'hsn_id', $hsns, old('hsn_id'))->class('form-select')->placeholder('Select') }}
                        @error('hsn_id')
                        <small class="text-danger">{{ $errors->first('hsn_id') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Manufacturer</label>
                        {{ html()->select($name = 'manufacturer_id', $manufacturers, old('manufacturer_id'))->class('form-select')->placeholder('Select') }}
                        @error('manufacturer_id')
                        <small class="text-danger">{{ $errors->first('manufacturer_id') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Selling Price</label>
                        {{ html()->number('selling_price', old('selling_price') ?? '', '0', '', '1')->class('form-control')->placeholder('0.00') }}
                        @error('selling_price')
                        <small class="text-danger">{{ $errors->first('selling_price') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Def.Del.Days </label>
                        {{ html()->number('default_delivery_days', old('default_delivery_days'), '0', '', '1')->class('form-control')->placeholder('0') }}
                        @error('default_delivery_days')
                        <small class="text-danger">{{ $errors->first('default_delivery_days') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Eligible for Advisor</label>
                        {{ html()->select($name = 'eligible_for_adviser', array('1' => 'Yes', '0' => 'No'), old('eligible_for_adviser'))->class('form-select')->placeholder('Select') }}
                        @error('eligible_for_adviser')
                        <small class="text-danger">{{ $errors->first('eligible_for_adviser') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-6">
                        <label class="form-label req">Product Description </label>
                        {{ html()->text('description', old('description'))->class('form-control')->placeholder('Product Description') }}
                        @error('description')
                        <small class="text-danger">{{ $errors->first('description') }}</small>
                        @enderror
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