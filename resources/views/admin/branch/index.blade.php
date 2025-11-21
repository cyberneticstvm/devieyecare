@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Branch Register</h5>
        <p class="fs-12">Showing registered branches</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Code</th>
                            <th class="py-2 fw-medium small text-uppercase">Email</th>
                            <th class="py-2 fw-medium small text-uppercase">Contact</th>
                            <th class="py-2 fw-medium small text-uppercase">Address</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $key => $branch)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $branch->name }}</td>
                            <td>{{ $branch->code }}</td>
                            <td>{{ $branch->email }}</td>
                            <td>{{ $branch->contact }}</td>
                            <td>{{ $branch->address }}</td>
                            <td>{!! $branch->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('branch.edit', encrypt($branch->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('branch.delete', encrypt($branch->id)) }}" class="text-danger dlt">Delete</a>
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