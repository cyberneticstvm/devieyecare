@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Daybook Report</h5>
        <p class="fs-12">Daybook Report</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('report.daybook.fetch')->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">Date </label>
                        {{ html()->date('ddate', old('ddate') ?? $inputs[0])->class('form-control') }}
                        @error('ddate')
                        <small class="text-danger">{{ $errors->first('ddate') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label req">Branch </label>
                        {{ html()->select('branch', $branches, old('branch') ?? $inputs[1])->class('form-control') }}
                        @error('branch')
                        <small class="text-danger">{{ $errors->first('branch') }}</small>
                        @enderror
                    </div>
                </div>
                <div class="raw mt-3">
                    <div class="col text-end">
                        {{ html()->button('Cancel')->class('btn btn-secondary')->attribute('onclick', 'window.history.back()')->attribute('type', 'button') }}
                        {{ html()->submit('Fetch')->class('btn btn-submit btn-primary') }}
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Daybook Report</h5>
        <p class="fs-12">Showing Daybook on {{ $inputs[0] }}</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include("admin.misc.drawer.order_detail")
@endsection