@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Inventory Status</h5>
        <p class="fs-12">Inventory Status</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-5">
                {{ html()->form('POST')->route('get.inventory')->class('d-flex')->attribute('role', 'search')->open() }}
                {{ html()->select('branch', $branches, $inputs[0])->class('select2')->placeholder('Select') }}
                {{ html()->submit('Fetch')->class('btn btn-submit btn-primary') }}
                {{ html()->form()->close() }}
                @error('branch')
                <small class="text-danger">{{ $errors->first('branch') }}</small>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Inventory Status</h5>
        <p class="fs-12">Showing inventory status</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">PId</th>
                            <th class="py-2 fw-medium small text-uppercase">Code</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Batch</th>
                            <th class="py-2 fw-medium small text-uppercase">Pur.Qty</th>
                            <th class="py-2 fw-medium small text-uppercase">Tr.In</th>
                            <th class="py-2 fw-medium small text-uppercase">Tr.Out</th>
                            <th class="py-2 fw-medium small text-uppercase">Billed</th>
                            <th class="py-2 fw-medium small text-uppercase">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->pid }}</td>
                            <td>{{ $item->pid }}</td>
                            <td>{{ $item->pname }}</td>
                            <td>{{ $item->batch }}</td>
                            <td>{{ $item->purchasedQty }}</td>
                            <td>{{ $item->transferInQty }}</td>
                            <td>{{ $item->transferOutQty }}</td>
                            <td>{{ $item->billedQty }}</td>
                            <td>{{ $item->balanceQty }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection