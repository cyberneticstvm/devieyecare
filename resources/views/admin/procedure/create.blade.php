@extends("admin.base")
@section("content")
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Prescription / Medicine / Procedure</h5>
        <p class="fs-12">Prescription / Medicine / Procedure</p>
        {{ html()->form('POST')->route('procedure.save', encrypt($registration?->id))->class('')->acceptsFiles()->open() }}
        <input type="hidden" name="procedure_id" value="{{ $registration?->procedure?->id ?? 0 }}">
        <div class="row g-lg-12 g-3">
            <h5>Spectacle Prescription - RE</h5>
            <div class="col-md-2 col-6">
                <label class="text-secondary">Sph</label>
                {{ html()->text('re_sph', $registration?->procedure?->re_sph ?? old('re_sph'))->class('form-control')->placeholder('Sph') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary"> Cyl</label>
                {{ html()->text('re_cyl', $registration?->procedure?->re_cyl ?? old('re_cyl'))->class('form-control')->placeholder('Cyl') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">Axis</label>
                {{ html()->text('re_axis', $registration?->procedure?->re_axis ?? old('re_axis'))->class('form-control')->placeholder('Axis') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">Add.</label>
                {{ html()->text('re_add', $registration?->procedure?->re_add ?? old('re_add'))->class('form-control')->placeholder('Add.') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">NV</label>
                {{ html()->text('re_nv', $registration?->procedure?->re_nv ?? old('re_nv'))->class('form-control')->placeholder('NV') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">DV</label>
                {{ html()->text('re_dv', $registration?->procedure?->re_dv ?? old('re_dv'))->class('form-control')->placeholder('DV') }}
            </div>
        </div>
        <div class="row g-lg-12 g-3 mt-3">
            <h5>Spectacle Prescription - LE</h5>
            <div class="col-md-2 col-6">
                <label class="text-secondary">Sph</label>
                {{ html()->text('le_sph', $registration?->procedure?->le_sph ?? old('le_sph'))->class('form-control')->placeholder('Sph') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">Cyl</label>
                {{ html()->text('le_cyl', $registration?->procedure?->le_cyl ?? old('le_cyl'))->class('form-control')->placeholder('Cyl') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">Axis</label>
                {{ html()->text('le_axis', $registration?->procedure?->le_axis ?? old('le_axis'))->class('form-control')->placeholder('Axis') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">Add.</label>
                {{ html()->text('le_add', $registration?->procedure?->le_add ?? old('le_add'))->class('form-control')->placeholder('Add.') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">NV</label>
                {{ html()->text('le_nv', $registration?->procedure?->le_nv ?? old('le_nv'))->class('form-control')->placeholder('NV') }}
            </div>
            <div class="col-md-2 col-6">
                <label class="text-secondary">DV</label>
                {{ html()->text('le_dv', $registration?->procedure?->le_dv ?? old('le_dv'))->class('form-control')->placeholder('DV') }}
            </div>
        </div>
        <div class="row g-lg-12 g-3 mt-5">
            <h5>Procedure / Medicine</h5>
        </div>
        @if($registration?->procedure?->medicines)
        @forelse($registration?->procedure?->medicines as $key => $item)
        <div class="row g-lg-12 g-3">
            <div class="col-md-3 col-12">
                {{ html()->select($name = 'product_ids[]', $value = $products, $item->product_id)->class('select2')->attribute('id', 'pid'.$item->product_id)->placeholder('Medicine / Procedure') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->text('dosage1[]', $item->dosage1)->class('form-control')->placeholder('Dosage') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->text('dosage2[]', $item->dosage2)->class('form-control')->placeholder('Dosage') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->text('dosage3[]', $item->dosage3)->class('form-control')->placeholder('Dosage') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->number('days[]', $item->days, '', '', '')->class('form-control')->placeholder('Days') }}
            </div>
        </div>
        <hr />
        @empty
        @endforelse
        @endif
        <div class="row g-lg-12 g-3">
            <div class="col-md-3 col-12">
                {{ html()->select($name = 'product_ids[]', $value = $products, null)->class('select2')->attribute('id', 'pid1')->placeholder('Medicine / Procedure') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->text('dosage1[]', null)->class('form-control')->placeholder('Dosage') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->text('dosage2[]', null)->class('form-control')->placeholder('Dosage') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->text('dosage3[]', null)->class('form-control')->placeholder('Dosage') }}
            </div>
            <div class="col-md-2 col-6">
                {{ html()->number('days[]', null, '', '', '')->class('form-control')->placeholder('Days') }}
            </div>
        </div>
        <div class="divMedicineRow">

        </div>
        <div class="row g-lg-12 g-3 mt-3">
            <div class="col text-center">
                <a href="javascript:void(0)" onclick="addRow('divmed')">Add New</a>
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