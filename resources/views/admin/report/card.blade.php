@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Card Report</h5>
        <p class="fs-12">Card Report</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                {{ html()->form('POST')->route('report.card.fetch')->class('')->open() }}
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
        <h5 class="fw-medium text-uppercase mb-0">Card Report</h5>
        <p class="fs-12">Showing Card Transaction between {{ $inputs[0] }} and {{ $inputs[1] }}</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Date</th>
                            <th class="py-2 fw-medium small text-uppercase">MRN</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Branch</th>
                            <th class="py-2 fw-medium small text-uppercase">DC</th>
                            <th class="py-2 fw-medium small text-uppercase">Pharmacy</th>
                            <th class="py-2 fw-medium small text-uppercase">Advance</th>
                            <th class="py-2 fw-medium small text-uppercase">Balance</th>
                            <th class="py-2 fw-medium small text-uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $tot = 0;
                        $doc_fee = 0;
                        $pharmacy = 0;
                        $advance = 0;
                        $balance = 0;
                        @endphp
                        @forelse($payments as $key => $item)
                        @php
                        $doc_fee = ($item->doc_fee_pmode == $card_pmode_id) ? $item->doc_fee : 0;
                        $pharmacy = $item->pharmacy?->where("pmode", $card_pmode_id)?->sum(DB::raw("total-discount"));
                        $advance = $item->order?->where("advance_pmode", $card_pmode_id)?->sum("advance") ?? 0;
                        $balance = $item->order?->payments?->where("pmode", $card_pmode_id)?->sum("amount") ?? 0;
                        $tot += $doc_fee + $pharmacy + $advance + $balance;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->created_at->format('d.M.Y') }}</td>
                            <td>{!! $item->getMrn() !!}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->branch->name }}</td>
                            <td class="text-end">{{ number_format($doc_fee, 2) }}</td>
                            <td class="text-end">{{ number_format($pharmacy, 2) }}</td>
                            <td class="text-end">{{ number_format($advance, 2) }}</td>
                            <td class="text-end">{{ number_format($balance, 2) }}</td>
                            <td class="text-end">{{ number_format($doc_fee + $pharmacy + $advance + $balance, 2) }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9" class="fw-bold text-end">Total</td>
                            <td class="fw-bold text-end">{{ number_format($tot, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection