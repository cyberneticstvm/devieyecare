@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Store Order - {{ $registration->getMrn() }}</h5>
        <p class="fs-12">Store Order</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('store.order.update', $registration->id)->attribute('id', 'orderForm')->class('')->open() }}
                <input type="hidden" name="oid" value="{{ $order ? encrypt($order->id) : encrypt(0) }}" />
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
                    <div class="control-group col-md-2">
                        <label class="form-label req">DC Pay Mode </label>
                        {{ html()->select('doc_fee_pmode', $extras->where('category', 'pmode')->pluck('name', 'id'), old('doc_fee_pmode') ?? $registration->doc_fee_pmode)->class('form-control')->attribute('id', 'doc_fee_pmode')->placeholder('Select') }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">Surgery Advised </label>
                        {{ html()->select('surgery_advised', array('0' => 'No', '1' => 'Yes'), old('surgery_advised') ?? $registration->surgery_advised)->class('form-control')->attribute('id', 'surgery_advised')->placeholder('Select') }}
                    </div>
                    <div class="control-group col-md-6">
                        <label class="form-label">Generate Invoice </label><br>
                        {{ html()->checkbox('invoice', $order?->invoice_number ? true : false, 1)->if($order?->invoice_number > 0, function($el){
                            return $el->attribute('disabled', 'disabled');
                        })->class('form-check-input') }}
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
                                    <th class="py-2 fw-medium small text-uppercase" style="width: 10%;">Price</th>
                                </tr>
                            </thead>
                            @if(!$order?->exists())
                            <tbody>
                                <tr>
                                    <td>
                                        {{ html()->text('eye[]', 'RE')->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye1')->attribute('readonly', true) }}
                                    </td>
                                    <td>
                                        {{ html()->select('sph[]', $extras->where('category', 'sph')->pluck('name', 'name'), old('sph') ?? '')->class('select2')->attribute('id', 'sph1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('cyl[]', $extras->where('category', 'cyl')->pluck('name', 'name'), old('cyl') ?? $extras->where('category', 'cyl')->where('other_info', 'selected')->first()->name)->class('select2')->attribute('id', 'cyl1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('axis[]', $axis, old('axis') ?? '')->class('select2')->attribute('id', 'axis1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('add[]', $extras->where('category', 'addition')->pluck('name', 'name'), old('add') ?? '')->class('select2')->attribute('id', 'add1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('dia[]', $dia, old('dia') ?? '')->class('select2')->attribute('id', 'dia1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('thickness[]', $extras->where('category', 'thickness')->pluck('name', 'id'), old('thickness') ?? '')->class('select2')->attribute('id', 'thick1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->text('ipd[]', old('ipd')[0] ?? '')->class('form-control')->attribute('id', 'ipd1')->placeholder('IPD') }}
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Lens')->id)->pluck('name', 'id'), old('product') ?? '')->class('select2 selectPdct')->attribute('id', 'pdct1')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', old('qty')[0] ?? '')->class('form-control qty text-end')->attribute('id', 'qty1')->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', old('price')[0] ?? '', '', '', 'any')->class('form-control price text-end')->attribute('id', 'price1')->attribute('readonly', true)->placeholder('0.00') }}
                                        <input type="hidden" name="price1[]" class="price1" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ html()->text('eye[]', 'LE')->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye2')->attribute('readonly', true) }}
                                    </td>
                                    <td>
                                        {{ html()->select('sph[]', $extras->where('category', 'sph')->pluck('name', 'name'), old('sph') ?? '')->class('select2')->attribute('id', 'sph2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('cyl[]', $extras->where('category', 'cyl')->pluck('name', 'name'), old('cyl') ?? '')->class('select2')->attribute('id', 'cyl2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('axis[]', $axis, old('axis') ?? '')->class('select2')->attribute('id', 'axis2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('add[]', $extras->where('category', 'addition')->pluck('name', 'name'), old('add') ?? '')->class('select2')->attribute('id', 'add2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('dia[]', $dia, old('dia') ?? '')->class('select2')->attribute('id', 'dia2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('thickness[]', $extras->where('category', 'thickness')->pluck('name', 'id'), old('thickness') ?? '')->class('select2')->attribute('id', 'thick2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->text('ipd[]', old('ipd')[1] ?? '')->class('form-control')->attribute('id', 'ipd2')->placeholder('IPD') }}
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Lens')->id)->pluck('name', 'id'), old('product') ?? '')->class('select2 selectPdct')->attribute('id', 'pdct2')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', old('qty')[1] ?? '')->class('form-control qty text-end')->attribute('id', 'qty2')->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', old('price')[1] ?? '', '', '', 'any')->class('form-control price text-end')->attribute('id', 'price2')->attribute('readonly', true)->placeholder('0.00') }}
                                        <input type="hidden" name="price1[]" class="price1" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ html()->text('eye[]', 'FRAME')->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye3')->attribute('readonly', true) }}
                                    </td>
                                    <td colspan="7">
                                        <input type="hidden" name="sph[]" value="" />
                                        <input type="hidden" name="cyl[]" value="" />
                                        <input type="hidden" name="axis[]" value="" />
                                        <input type="hidden" name="add[]" value="" />
                                        <input type="hidden" name="dia[]" value="" />
                                        <input type="hidden" name="thickness[]" value="" />
                                        <input type="hidden" name="ipd[]" value="" />
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Frame')->id)->pluck('name', 'id'), old('product') ?? '')->class('select2 selectPdct')->attribute('id', 'pdct3')->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', old('qty')[2] ?? '')->class('form-control qty text-end')->attribute('id', 'qty3')->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', old('price')[2] ?? '', '', '', 'any')->class('form-control price text-end')->attribute('id', 'price3')->attribute('readonly', true)->placeholder('0.00') }}
                                        <input type="hidden" name="price1[]" class="price1" value="" />
                                    </td>
                                </tr>
                            </tbody>
                            @else
                            <tbody>
                                @forelse($order->details as $key => $item)
                                @if(in_array($item->eye, ['RE', 'LE']))
                                <tr>
                                    <td>
                                        {{ html()->text('eye[]', $item->eye)->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye'.$item->id)->attribute('readonly', true) }}
                                    </td>
                                    <td>
                                        {{ html()->select('sph[]', $extras->where('category', 'sph')->pluck('name', 'name'), $item->sph)->class('select2')->attribute('id', 'sph'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('cyl[]', $extras->where('category', 'cyl')->pluck('name', 'name'), $item->cyl ?? $extras->where('category', 'cyl')->where('other_info', 'selected')->first()->name)->class('select2')->attribute('id', 'cyl'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('axis[]', $axis, $item->axis)->class('select2')->attribute('id', 'axis'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('add[]', $extras->where('category', 'addition')->pluck('name', 'name'), $item->addition)->class('select2')->attribute('id', 'add'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('dia[]', $dia, $item->dia)->class('select2')->attribute('id', 'dia'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->select('thickness[]', $extras->where('category', 'thickness')->pluck('name', 'id'), $item->thick)->class('select2')->attribute('id', 'thick'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->text('ipd[]', $item->ipd)->class('form-control')->attribute('id', 'ipd'.$item->id)->placeholder('IPD') }}
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Lens')->id)->pluck('name', 'id'), $item->product_id)->class('select2 selectPdct')->attribute('id', 'pdct'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', $item->qty)->class('form-control qty text-end')->attribute('id', 'qty'.$item->id)->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', $item->price, '', '', 'any')->class('form-control price text-end')->attribute('id', 'price'.$item->id)->attribute('readonly', true)->placeholder('0.00') }}
                                        <input type="hidden" name="price1[]" class="price1" value="" />
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td>
                                        {{ html()->text('eye[]', $item->eye)->class('form-control')->maxlength(5)->placeholder('')->attribute('id', 'eye'.$item->id)->attribute('readonly', true) }}
                                    </td>
                                    <td colspan="7">
                                        <input type="hidden" name="sph[]" value="" />
                                        <input type="hidden" name="cyl[]" value="" />
                                        <input type="hidden" name="axis[]" value="" />
                                        <input type="hidden" name="add[]" value="" />
                                        <input type="hidden" name="dia[]" value="" />
                                        <input type="hidden" name="thickness[]" value="" />
                                        <input type="hidden" name="ipd[]" value="" />
                                    </td>
                                    <td>
                                        {{ html()->select('product[]', $products->where('hsn_id', hsn('Frame')->id)->pluck('name', 'id'), $item->product_id)->class('select2 selectPdct')->attribute('id', 'pdct'.$item->id)->placeholder('Select') }}
                                    </td>
                                    <td>
                                        {{ html()->number('qty[]', $item->qty)->class('form-control qty text-end')->attribute('id', 'qty'.$item->id)->placeholder('0') }}
                                    </td>
                                    <td>
                                        {{ html()->number('price[]', $item->price, '', '', 'any')->class('form-control price text-end')->attribute('id', 'price'.$item->id)->attribute('readonly', true)->placeholder('0.00') }}
                                        <input type="hidden" name="price1[]" class="price1" value="" />
                                    </td>
                                </tr>
                                @endif
                                @empty
                                @endforelse
                            </tbody>
                            @endif
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="fw-bold text-end">Discount</td>
                                    <td>
                                        {{ html()->number('discount', $order?->discount, '', '', 'any')->class('form-control discount text-end')->placeholder('0.00') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold text-end">Total</td>
                                    <td>
                                        {{ html()->number('total', $order?->total, '', '', 'any')->class('form-control total text-end')->attribute('readonly', true)->placeholder('0.00') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Expected Del. Date</td>
                                    <td colspan="2">Post Review Date</td>
                                    <td>Pdct. Advisor</td>
                                    <td colspan="3" class="fw-bold text-end">Advance</td>
                                    <td colspan="2">
                                        {{ html()->select('advance_pmode', $extras->where('category', 'pmode')->pluck('name', 'id'), $order?->advance_pmode)->class('form-control')->attribute('id', 'advance_pmode')->placeholder('Select Advance Pay Mode') }}
                                    </td>
                                    <td>
                                        {{ html()->number('advance', $order?->advance, '', '', 'any')->class('form-control advance text-end')->placeholder('0.00') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ html()->date('due_date', $order?->due_date?->format('y-m-d'))->class('form-control') }}
                                    </td>
                                    <td colspan="2">
                                        {{ html()->date('post_review_date', old('due_date') ?? $registration?->post_review_date?->format('Y-m-d'))->class('form-control') }}
                                    </td>
                                    <td colspan="2">
                                        {{ html()->select('product_advisor', $advisors, $order?->product_advisor)->class('form-control')->attribute('id', 'product_advisor')->placeholder('Select') }}
                                    </td>
                                    <td colspan="3">
                                        {{ html()->text('remarks', $order?->remarks)->class('form-control')->placeholder('Remarks') }}
                                    </td>
                                    <td class="fw-bold text-end">Balance</td>
                                    <td>
                                        {{ html()->text('balance', ($order?->exists()) ? number_format(getStoreDueAmount($order->registration_id, 0), 2) : '0.00')->class('form-control balance text-end')->attribute('readonly', 'true')->placeholder('0.00') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-end text-primary">Payments made through other channels: {{ $order?->payments()?->sum('amount') }}</div>
                </div>
                <div class="raw mt-3">
                    <div class="col text-end">
                        {{ html()->button('Cancel')->class('btn btn-secondary')->attribute('onclick', 'window.history.back()')->attribute('type', 'button') }}
                        {{ html()->submit(($order) ? 'Update' : 'Save')->attribute('onclick', 'return validateOrderForm()')->class('btn btn-submit btn-primary') }}
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
@endsection