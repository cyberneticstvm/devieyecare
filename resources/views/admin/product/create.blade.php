@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Create New Product</h5>
        <p class="fs-12">Create New Product</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('product.save')->class('')->acceptsFiles()->open() }}
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
                <div class="row g-3 mt-3">
                    <h5>Details for Speckson</h5>
                    <div class="control-group col-md-2">
                        <label class="form-label">Frame Type</label>
                        {{ html()->select($name = 'frame_type', $ftypes, old('frmae_type'))->class('form-select')->placeholder('Select') }}
                        @error('frame_type')
                        <small class="text-danger">{{ $errors->first('frame_type') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Frame Material</label>
                        {{ html()->select($name = 'material', $fmaterial, old('material'))->class('form-select')->placeholder('Select') }}
                        @error('material')
                        <small class="text-danger">{{ $errors->first('material') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Avatar</label>
                        {{ html()->select($name = 'avatar', $avatars, old('avatar'))->class('form-select')->placeholder('Select') }}
                        @error('avatar')
                        <small class="text-danger">{{ $errors->first('avatar') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">DIA</label>
                        {{ html()->text('dia', old('dia'))->class('form-control')->placeholder('DIA') }}
                        @error('dia')
                        <small class="text-danger">{{ $errors->first('dia') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Temple Size</label>
                        {{ html()->text('temple_size', old('temple_size'))->class('form-control')->placeholder('Temple Size') }}
                        @error('temple_size')
                        <small class="text-danger">{{ $errors->first('temple_size') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Bridge Size</label>
                        {{ html()->text('bridge_size', old('bridge_size'))->class('form-control')->placeholder('Bridge Size') }}
                        @error('bridge_size')
                        <small class="text-danger">{{ $errors->first('bridge_size') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Product Weight</label>
                        {{ html()->text('weight', old('weight'))->class('form-control')->placeholder('Weight') }}
                        @error('weight')
                        <small class="text-danger">{{ $errors->first('weight') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Model Name</label>
                        {{ html()->text('model_name', old('model_name'))->class('form-control')->placeholder('Model Name') }}
                        @error('model_name')
                        <small class="text-danger">{{ $errors->first('model_name') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Brand</label>
                        {{ html()->select($name = 'brand', $brands, old('brand'))->class('form-select')->placeholder('Select') }}
                        @error('brand')
                        <small class="text-danger">{{ $errors->first('brand') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label">Product Image <small class="text-danger">Recommended size: W: 1620px, H: 775px</small></label>
                        {{ html()->file('product_image')->class('form-control') }}
                        @error('product_image')
                        <small class="text-danger">{{ $errors->first('product_image') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label">Avatar Image <small class="text-danger"></small></label>
                        {{ html()->file('avatar_image')->class('form-control') }}
                        @error('avatar_image')
                        <small class="text-danger">{{ $errors->first('avatar_image') }}</small>
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