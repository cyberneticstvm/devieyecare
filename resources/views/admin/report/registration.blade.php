@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">registration Report</h5>
        <p class="fs-12">Registration Report</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('report.registration.fetch')->class('')->open() }}
                <div class="row g-3">
                    <div class="control-group col-md-2">
                        <label class="form-label req">From Date </label>
                        {{ html()->date('from_date', old('from_date') ?? $inputs[0])->class('form-control') }}
                        @error('from_date')
                        <small class="text-danger">{{ $errors->first('from_date') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label req">To Date </label>
                        {{ html()->date('to_date', old('to_date') ?? $inputs[1])->class('form-control') }}
                        @error('to_date')
                        <small class="text-danger">{{ $errors->first('to_date') }}</small>
                        @enderror
                    </div>
                    <div class="control-group col-md-3">
                        <label class="form-label">Branch </label>
                        {{ html()->select('branch', $branches, old('branch') ?? $inputs[2])->class('form-control') }}
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
        <h5 class="fw-medium text-uppercase mb-0">Registration Report</h5>
        <p class="fs-12">Showing registration between {{ $inputs[0] }} and {{ $inputs[1] }}</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Mrn</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Age</th>
                            <th class="py-2 fw-medium small text-uppercase">Gender</th>
                            <th class="py-2 fw-medium small text-uppercase">Contact</th>
                            <th class="py-2 fw-medium small text-uppercase">Address</th>
                            <th class="py-2 fw-medium small text-uppercase">Doctor</th>
                            <th class="py-2 fw-medium small text-uppercase">Doc.Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->created_at->format('d.M.Y') }}</td>
                            <td><a class="orderDetailsDrawer" data-bs-toggle="offcanvas" href="#OrderDetails" role="button" aria-controls="OrderDetails" aria-label="thunder AI theme setting" data-rid="{{ encrypt($item->id) }}" data-type="reg">{!! $item->getMrn() !!}</a></td>
                            <td>{{ $item->name }}</a></td>
                            <td>{{ $item->getAge() }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->mobile }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->doctor->name }}</td>
                            <td>{{ $item->doc_fee }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9" class="fw-bold text-end">Total</td>
                            <td class="fw-bold">{{ number_format($records?->sum('doc_fee'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@include("admin.misc.drawer.order_detail")
@endsection