@extends("admin.base")
@section("content")
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Procedure</h5>
        <p class="fs-12">Procedure</p>
        {{ html()->form('POST')->route('procedure.save', encrypt($registration?->id))->class('')->acceptsFiles()->open() }}
        <input type="hidden" name="procedure_id" value="{{ $registration?->procedure?->id ?? 0 }}">
        <div class="row g-lg-12 g-3">
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>Basic Details</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="control-group col-md-3">
                                        {{ html()->text('iop', $registration?->procedure?->iop ?? old('iop'))->class('form-control')->placeholder('IOP') }}
                                    </div>
                                    <div class="control-group col-md-3">
                                        {{ html()->text('bs', $registration?->procedure?->bs ?? old('bs'))->class('form-control')->placeholder('BS') }}
                                    </div>
                                    <div class="control-group col-md-3">
                                        {{ html()->text('bp', $registration?->procedure?->bp ?? old('bp'))->class('form-control')->placeholder('BP') }}
                                    </div>
                                    <div class="control-group col-md-3">
                                        <label class="form-label">Allergic </label>
                                        {{ html()->checkbox('allergic', $registration?->procedure?->allergic ? true : false, 1)->class('form-check-input') }}
                                    </div>
                                    <div class="control-group col-md-12">
                                        {{ html()->textarea('history', $registration?->procedure?->history ?? old('history'))->class('form-control')->placeholder('History') }}
                                    </div>
                                    <div class="control-group col-md-6">
                                        {{ html()->textarea('re_co', $registration?->procedure?->re_co ?? old('re_co'))->class('form-control')->placeholder('RE C/O') }}
                                    </div>
                                    <div class="control-group col-md-6">
                                        {{ html()->textarea('le_co', $registration?->procedure?->le_co ?? old('le_co'))->class('form-control')->placeholder('LE C/O') }}
                                    </div>
                                    <div class="control-group col-md-12">
                                        {{ html()->textarea('diagnosis', $registration?->procedure?->diagnosis ?? old('diagnosis'))->class('form-control')->placeholder('Provisional Diagnosis') }}
                                    </div>
                                    <div class="control-group col-md-12">
                                        {{ html()->textarea('treatment', $registration?->procedure?->treatment ?? old('treatment'))->class('form-control')->placeholder('Treatment') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>Other Details</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="control-group col-md-3">
                                        {{ html()->text('ipd', $registration?->procedure?->ipd ?? old('ipd'))->class('form-control')->placeholder('IPD') }}
                                    </div>
                                    <div class="control-group col-md-9">
                                        {{ html()->text('remarks', $registration?->procedure?->remarks ?? old('remarks'))->class('form-control')->placeholder('Remarks') }}
                                    </div>
                                    <div class="control-group col-md-12">
                                        {{ html()->file('file_attachment[]')->class('form-control')->multiple() }}
                                    </div>
                                    <div class="control-group col-md-4">
                                        <label class="form-label">DCT </label>
                                        {{ html()->checkbox('dct', $registration?->procedure?->dct ? true : false, 1)->class('form-check-input') }}
                                    </div>
                                    <div class="control-group col-md-4">
                                        <label class="form-label">I & C </label>
                                        {{ html()->checkbox('ic', $registration?->procedure?->ic ? true : false, 1)->class('form-check-input') }}
                                    </div>
                                    <div class="control-group col-md-4">
                                        <label class="form-label">Suture </label>
                                        {{ html()->checkbox('suture', $registration?->procedure?->suture ? true : false, 1)->class('form-check-input') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <div class="row g-lg-12 g-3">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th class="text-center">Medicine</th>
                                            <th colspan="3" class="text-center">Dosage</th>
                                            <th>Days</th>
                                        </thead>
                                        <tbody class="medicineRow">
                                            @if($registration?->procedure?->medicines)
                                            @forelse($registration?->procedure?->medicines as $key => $item)
                                            <tr>
                                                <td>
                                                    {{ html()->select($name = 'product_ids[]', $value = $products, $item->product_id)->class('select2')->attribute('id', 'pid'.$item->product_id)->placeholder('Select') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('dosage1[]', $item->dosage1)->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('dosage2[]', $item->dosage2)->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('dosage3[]', $item->dosage3)->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->number('days[]', $item->days, '', '', '')->class('form-control')->placeholder('0') }}
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                            @endif
                                            <tr>
                                                <td>
                                                    {{ html()->select($name = 'product_ids[]', $value = $products, '')->class('select2')->attribute('id', 'pid1')->placeholder('Select') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('dosage1[]', '')->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('dosage2[]', '')->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('dosage3[]', '')->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->number('days[]', '', '', '', '')->class('form-control')->placeholder('0') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-center"><a href="javascript:void(0)" onclick="addRow('medicine')">Add New</a></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <div class="row g-lg-12 g-3">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th colspan="2" class="text-center">Vision</th>
                                            <th colspan="2" class="text-center">Corrected Vision</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>RE</td>
                                                <td>
                                                    {{ html()->text('re_vision', $registration?->procedure?->re_vision ?? old('re_vision'))->class('form-control')->placeholder('Vision') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('re_dv', $registration?->procedure?->re_dv ?? old('re_dv'))->class('form-control')->placeholder('DV') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('re_nv', $registration?->procedure?->re_nv ?? old('re_nv'))->class('form-control')->placeholder('NV') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>LE</td>
                                                <td>
                                                    {{ html()->text('le_vision', $registration?->procedure?->le_vision ?? old('le_vision'))->class('form-control')->placeholder('Vision') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('le_dv', $registration?->procedure?->le_dv ?? old('le_dv'))->class('form-control')->placeholder('DV') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('le_nv', $registration?->procedure?->le_nv ?? old('le_nv'))->class('form-control')->placeholder('NV') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <div class="row g-lg-12 g-3">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th colspan="4" class="text-center">ARM</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>RE</td>
                                                <td>
                                                    {{ html()->text('re_arm1', $registration?->procedure?->re_arm1 ?? old('re_arm1'))->class('form-control')->placeholder('Arm') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('re_arm2', $registration?->procedure?->re_arm2 ?? old('re_arm2'))->class('form-control')->placeholder('Arm') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('re_arm3', $registration?->procedure?->re_arm3 ?? old('re_arm3'))->class('form-control')->placeholder('Arm') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>LE</td>
                                                <td>
                                                    {{ html()->text('le_arm1', $registration?->procedure?->le_arm1 ?? old('le_arm1'))->class('form-control')->placeholder('Arm') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('le_arm2', $registration?->procedure?->le_arm2 ?? old('le_arm2'))->class('form-control')->placeholder('Arm') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('le_arm3', $registration?->procedure?->le_arm3 ?? old('le_arm3'))->class('form-control')->placeholder('Arm') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <div class="row g-lg-12 g-3">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th colspan="5" class="text-center">Lens Prescription</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>RE</td>
                                                <td>
                                                    {{ html()->text('re_sph', $registration?->procedure?->re_sph ?? old('re_sph'))->class('form-control')->placeholder('Sph') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('re_cyl', $registration?->procedure?->re_cyl ?? old('re_cyl'))->class('form-control')->placeholder('Cyl') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('re_axis', $registration?->procedure?->re_axis ?? old('re_axis'))->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('re_add', $registration?->procedure?->re_add ?? old('re_add'))->class('form-control')->placeholder('0.0') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>LE</td>
                                                <td>
                                                    {{ html()->text('le_sph', $registration?->procedure?->le_sph ?? old('le_sph'))->class('form-control')->placeholder('Sph') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('le_cyl', $registration?->procedure?->le_cyl ?? old('le_cyl'))->class('form-control')->placeholder('Cyl') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('le_axis', $registration?->procedure?->le_axis ?? old('le_axis'))->class('form-control')->placeholder('0') }}
                                                </td>
                                                <td>
                                                    {{ html()->text('le_add', $registration?->procedure?->le_add ?? old('le_add'))->class('form-control')->placeholder('0.0') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
@endsection