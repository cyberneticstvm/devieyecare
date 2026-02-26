@extends("admin.base")
@section("content")
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">{{ $category }}</h5>
        <p class="fs-12">{{ $category }}</p>
        {{ html()->form('POST')->route('procedure.save', encrypt($registration?->id))->class('')->acceptsFiles()->open() }}
        <input type="hidden" name="procedure_id" value="{{ $registration?->procedure?->id ?? 0 }}">
        <input type="hidden" name="category" value="{{ $category }}">
        @if($category == "Medicine" || $category == "Procedure")
        <div class="row g-lg-12 g-3">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th class="text-center w-50">{{ $category }}</th>
                        <th colspan="3" class="text-center w-40">Dosage</th>
                        <th class="w-10">Days</th>
                    </thead>
                    <tbody class="medicineRow">
                        @if($registration?->procedure?->medicines)
                        @forelse($registration?->procedure?->medicines->where("category", $category) as $key => $item)
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
        @endif
        @if($category == "Spectacle")
        <div class="row g-lg-12 g-3">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center">Lens Prescription</th>
                        </tr>
                        <tr>
                            <th>Eye</th>
                            <th>Sph</th>
                            <th>Cyl</th>
                            <th>Axis</th>
                            <th>Add.</th>
                            <th>NV</th>
                            <th>DV</th>
                        </tr>
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
                            <td>
                                {{ html()->text('re_nv', $registration?->procedure?->re_nv ?? old('re_nv'))->class('form-control')->placeholder('NV') }}
                            </td>
                            <td>
                                {{ html()->text('re_dv', $registration?->procedure?->re_dv ?? old('re_dv'))->class('form-control')->placeholder('DV') }}
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
                            <td>
                                {{ html()->text('le_nv', $registration?->procedure?->le_nv ?? old('le_nv'))->class('form-control')->placeholder('NV') }}
                            </td>
                            <td>
                                {{ html()->text('le_dv', $registration?->procedure?->le_dv ?? old('le_dv'))->class('form-control')->placeholder('DV') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
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