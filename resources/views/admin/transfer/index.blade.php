@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Transfer Register</h5>
        <p class="fs-12">Transfer Register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Tr.Id</th>
                            <th class="py-2 fw-medium small text-uppercase">Tr.Date</th>
                            <th class="py-2 fw-medium small text-uppercase">From Br.</th>
                            <th class="py-2 fw-medium small text-uppercase">To Br.</th>
                            <th class="py-2 fw-medium small text-uppercase">Bill</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $key => $transfer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $transfer->id }}</td>
                            <td>{{ $transfer->tdate->format('d.M.Y') }}</td>
                            <td>{{ $transfer->fbranch->name }}</td>
                            <td>{{ $transfer->tbranch->name }}</td>
                            <td></td>
                            <td>{!! $transfer->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('transfer.edit', encrypt($transfer->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('transfer.delete', encrypt($transfer->id)) }}" class="text-danger dlt">Delete</a>
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