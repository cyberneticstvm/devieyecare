@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Sales Report - Store</h5>
        <p class="fs-12">Store Sales Report</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('report.sales.fetch')->class('')->open() }}
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
                    <div class="control-group col-md-2">
                        <label class="form-label">Branch </label>
                        {{ html()->select('branch', $branches, old('branch') ?? $inputs[2])->class('form-control') }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Advisor </label>
                        {{ html()->select('advisor', $advisors, old('advisor') ?? $inputs[3])->class('form-control') }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Type </label>
                        {{ html()->select('rtype', $rtypes, old('rtype') ?? $inputs[4])->class('form-control') }}
                    </div>
                    <div class="control-group col-md-2">
                        <label class="form-label">Product </label>
                        {{ html()->select('product_id', $products, old('product_id') ?? $inputs[5])->class('select2') }}
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
        <h5 class="fw-medium text-uppercase mb-0">Sales Report - Store</h5>
        <p class="fs-12">Showing sales between {{ $inputs[0] }} and {{ $inputs[1] }}</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Mrn</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Invoice</th>
                            <th class="py-2 fw-medium small text-uppercase">Advisor</th>
                            <th class="py-2 fw-medium small text-uppercase">Branch</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Doc.Fee</th>
                            <th class="py-2 fw-medium small text-uppercase">Discount</th>
                            <th class="py-2 fw-medium small text-uppercase">Advance</th>
                            <th class="py-2 fw-medium small text-uppercase">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $atot = 0;
                        $btot = 0;
                        $atott = 0;
                        $btott = 0;
                        $fee_tot = 0;
                        @endphp
                        @forelse($records as $key => $item)
                        @php
                        $atot = $item->advance + $item->payments()->sum('amount');
                        $btot = $item->total - $atot;
                        $atott += $atot;
                        $btott += $btot;
                        $fee_tot += $item?->registration?->doc_fee ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->created_at->format('d.M.Y') }}</td>
                            <td>{!! $item?->registration?->getMrn() !!}</td>
                            <td>{{ $item?->registration?->name }}</td>
                            <td>{!! $item->ino() !!}</td>
                            <td>{{ $item?->advisor?->name }}</td>
                            <td>{{ $item?->branch?->name }}</td>
                            <td>{{ $item?->ostatus?->name }}</td>
                            <td>{{ $item?->registration?->doc_fee }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ number_format($atot, 2) }}</td>
                            <td>{{ number_format($btot, 2) }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="fw-bold text-end">Total</td>
                            <td class="fw-bold">{{ number_format($fee_tot, 2) }}</td>
                            <td class="fw-bold">{{ number_format($records?->sum('discount'), 2) }}</td>
                            <td class="fw-bold">{{ number_format($atott, 2) }}</td>
                            <td class="fw-bold">{{ number_format($btott, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection