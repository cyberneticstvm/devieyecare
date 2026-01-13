@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
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
                            <th colspan="5"></th>
                            <th colspan="2" class="border text-center">DC</th>
                            <th colspan="2" class="border text-center">Pharmacy</th>
                            <th colspan="2" class="border text-center">Advance</th>
                            <th colspan="2"></th>
                        </tr>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Reg.Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Mrn</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Cash</th>
                            <th class="py-2 fw-medium small text-uppercase">Card</th>
                            <th class="py-2 fw-medium small text-uppercase">Cash</th>
                            <th class="py-2 fw-medium small text-uppercase">Card</th>
                            <th class="py-2 fw-medium small text-uppercase">Cash</th>
                            <th class="py-2 fw-medium small text-uppercase">Card</th>
                            <th class="py-2 fw-medium small text-uppercase">Balance</th>
                            <th class="py-2 fw-medium small text-uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $key => $item)
                        <tr class="{{ ($item->type == 'payment') ? 'rowbg' : '' }}">
                            <td>{{ $key + 1 }}</td>
                            <td></td>
                            <td>{!! $item->getMrn() !!}</td>
                            <td>{{ $item->cname }}</td>
                            <td>{{ $item->ostatus?->name }}</td>
                            <td>{{ $item->doc_fee_cash }}</td>
                            <td>{{ $item->doc_fee_card }}</td>
                            <td>{{ $item->ph_cash }}</td>
                            <td>{{ $item->ph_card }}</td>
                            <td>{{ $item->advance_cash }}</td>
                            <td>{{ $item->advance_card }}</td>
                            <td>{{ $item->balance }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="fw-bold text-end">Total</td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="DC-Cash" class="text-dark">{{ number_format($records->sum('doc_fee_cash'), 2) }}</a></td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="DC-Card" class="text-dark">{{ number_format($records->sum('doc_fee_card'), 2) }}</a></td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="Pharma-Cash" class="text-dark">{{ number_format($records->sum('ph_cash'), 2) }}</a></td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="Pharma-Card" class="text-dark">{{ number_format($records->sum('ph_card'), 2) }}</a></td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="Advance-Cash" class="text-dark">{{ number_format($records->sum('advance_cash'), 2) }}</a></td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="Advance-Card" class="text-dark">{{ number_format($records->sum('advance_card'), 2) }}</a></td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="Balance" class="text-dark">{{ number_format($records->sum('balance'), 2) }}</a></td>
                            <td class="fw-bold"><a href="#" data-toggle="tooltip" data-placement="top" title="Total" class="text-dark">{{ number_format($records->sum('total'), 2) }}</a></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="fw-bold">Cash Total</td>
                            <td colspan="8" class="fw-bold">{{ number_format($records->sum('doc_fee_cash') + $records->sum('ph_cash') + $records->sum('advance_cash'), 2) }}</td>
                            <td colspan="2" class="fw-bold text-end">Expenses</td>
                            <td class="fw-bold"><a class="expensesDrawer" data-bs-toggle="offcanvas" href="#expenseDetails" role="button" aria-controls="expenseDetails" data-ddate="{{ $inputs[0] }}" data-branch="{{ $inputs[1] }}">{{ number_format($expenses->sum('amount'), 2) }}</a></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="fw-bold">Card Total</td>
                            <td colspan="8" class="fw-bold">{{ number_format($records->sum('doc_fee_card') + $records->sum('ph_card') + $records->sum('advance_card'), 2) }}</td>
                            <td colspan="2" class="fw-bold text-end">Vehicle Payments</td>
                            <td class="fw-bold"><a class="vPaymentDrawer" data-bs-toggle="offcanvas" href="#vPaymentsDetails" role="button" aria-controls="vPaymentsDetails" data-ddate="{{ $inputs[0] }}" data-branch="{{ $inputs[1] }}">{{ number_format($vpayments->sum('amount'), 2) }}</a></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@include("admin.misc.drawer.expenses_daybook")
@include("admin.misc.drawer.vehicle_payments_daybook")
@endsection