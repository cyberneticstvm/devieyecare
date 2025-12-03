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
                <div class="raw mt-5">
                    <div class="col-lg-12">
                        <h5 class="fw-medium mb-3">Product Details</h5>
                        <table class="table table-round align-middle mb-0 table-hover w-100 mt-2 border-top">
                            <thead>
                                <tr>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">EYE</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">SPH</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">CYL</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">AXIS</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">ADD</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">DIA</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 10%;">THICK</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">IPD</th>
                                    <th class="py-2 fw-medium small text-uppercase">Product</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 5%;">Qty</th>
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 7%;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ html()->text('eye', 'RE')->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye1')->attribute('readonly', true) }}
                                    </td>
                                    <td>
                                        {{ html()->select('sph[]', $extras->where('category', 'sph')->pluck('name', 'name'), old('sph') ?? '')->class('select2')->attribute('id', 'sph1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('cyl[]', $extras->where('category', 'cyl')->pluck('name', 'name'), old('cyl') ?? '')->class('select2')->attribute('id', 'cyl1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('axis[]', $extras->where('category', 'axis')->pluck('name', 'name'), old('axis') ?? '')->class('select2')->attribute('id', 'axis1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('add[]', $extras->where('category', 'addition')->pluck('name', 'name'), old('add') ?? '')->class('select2')->attribute('id', 'add1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('dia[]', $extras->where('category', 'axis')->pluck('name', 'name'), old('dia') ?? '')->class('select2')->attribute('id', 'dia1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('thickness[]', $extras->where('category', 'thickness')->pluck('name', 'id'), old('thickness') ?? '')->class('select2')->attribute('id', 'thick1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->text('ipd[]', old('ipd') ?? '')->class('form-control')->attribute('id', 'ipd1')->placeholder('IPD') }}
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Lens')->id)->pluck('name', 'id'), old('product') ?? '')->class('select2')->attribute('id', 'pdct1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', old('qty') ?? '')->class('form-control')->attribute('id', 'qty1')->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', '', old('price') ?? '')->class('form-control')->attribute('id', 'price1')->placeholder('0.00') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ html()->text('eye', 'LE')->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye2')->attribute('readonly', true) }}
                                    </td>
                                    <td>
                                        {{ html()->select('sph[]', $extras->where('category', 'sph')->pluck('name', 'name'), old('sph') ?? '')->class('select2')->attribute('id', 'sph2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('cyl[]', $extras->where('category', 'cyl')->pluck('name', 'name'), old('cyl') ?? '')->class('select2')->attribute('id', 'cyl2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('axis[]', $extras->where('category', 'axis')->pluck('name', 'name'), old('axis') ?? '')->class('select2')->attribute('id', 'axis2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('add[]', $extras->where('category', 'addition')->pluck('name', 'name'), old('add') ?? '')->class('select2')->attribute('id', 'add2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('dia[]', $extras->where('category', 'dia')->pluck('name', 'name'), old('dia') ?? '')->class('select2')->attribute('id', 'dia2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('thickness[]', $extras->where('category', 'thickness')->pluck('name', 'id'), old('thickness') ?? '')->class('select2')->attribute('id', 'thick2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->text('ipd[]', old('ipd') ?? '')->class('form-control')->attribute('id', 'ipd2')->placeholder('IPD') }}
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Lens')->id)->pluck('name', 'id'), old('product') ?? '')->class('select2')->attribute('id', 'pdct2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', old('qty') ?? '')->class('form-control')->attribute('id', 'qty2')->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', '', old('price') ?? '')->class('form-control')->attribute('id', 'price2')->placeholder('0.00') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ html()->text('eye', 'FRAME')->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye3')->attribute('readonly', true) }}
                                    </td>
                                    <td colspan="7">
                                        <input type="hidden" name="sph[]" value="" />
                                        <input type="hidden" name="cyl[]" value="" />
                                        <input type="hidden" name="axis[]" value="" />
                                        <input type="hidden" name="addition[]" value="" />
                                        <input type="hidden" name="dia[]" value="" />
                                        <input type="hidden" name="thickness[]" value="" />
                                        <input type="hidden" name="ipd[]" value="" />
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Frame')->id)->pluck('name', 'id'), old('product') ?? '')->class('select2')->attribute('id', 'pdct3')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', old('qty') ?? '')->class('form-control')->attribute('id', 'qty3')->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', '', old('price') ?? '')->class('form-control')->attribute('id', 'price3')->placeholder('0.00') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="raw mt-5">
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