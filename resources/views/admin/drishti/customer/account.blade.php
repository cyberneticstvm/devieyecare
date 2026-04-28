@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Customer Account Register</h5>
        <p class="fs-12">Showing customer Account details</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Customer</th>
                            <th class="py-2 fw-medium small text-uppercase">Amount</th>
                            <th class="py-2 fw-medium small text-uppercase">Payment Mode</th>
                            <th class="py-2 fw-medium small text-uppercase">Type</th>
                            <th class="py-2 fw-medium small text-uppercase">Description</th>
                            <th class="py-2 fw-medium small text-uppercase">Payment Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Delete</th>`
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $key => $account)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $account->customer->name }}</td>
                            <td>{{ $account->amount }}</td>
                            <td>{{ $account->pmode->name }}</td>
                            <td>{{ $account->payment_type }}</td>
                            <td>{{ $account->description }}</td>
                            <td>{{ $account->payment_date->format('d.M.Y') }}</td>
                            <td>{!! $account->cancelled() !!}</td>
                            <td class="text-center">
                                <form action="{{ route('drishti.customer.account.delete', encrypt($account->id)) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure want to delete this record?')">
                                        Delete
                                    </button>
                                </form>
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