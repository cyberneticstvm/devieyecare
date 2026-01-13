@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Purchase Register</h5>
        <p class="fs-12">Purchase Register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Pur.Id</th>
                            <th class="py-2 fw-medium small text-uppercase">Pur.Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Supplier</th>
                            <th class="py-2 fw-medium small text-uppercase">Invoice</th>
                            <th class="py-2 fw-medium small text-uppercase">Bill</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $key => $purchase)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $purchase->id }}</td>
                            <td>{{ $purchase->pdate->format('d.M.Y') }}</td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>{{ $purchase->invoice }}</td>
                            <td></td>
                            <td>{!! $purchase->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('purchase.edit', encrypt($purchase->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('purchase.delete', encrypt($purchase->id)) }}" class="text-danger dlt">Delete</a>
                            </td>
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