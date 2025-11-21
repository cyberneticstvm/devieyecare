@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Doctor Register</h5>
        <p class="fs-12">Showing registered doctors</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Doctor Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Code</th>
                            <th class="py-2 fw-medium small text-uppercase">Qualification</th>
                            <th class="py-2 fw-medium small text-uppercase">Email</th>
                            <th class="py-2 fw-medium small text-uppercase">Mobile</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $key => $doctor)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->code }}</td>
                            <td>{{ $doctor->qualification }}</td>
                            <td>{{ $doctor->email }}</td>
                            <td>{{ $doctor->mobile }}</td>
                            <td class="text-center">{!! $doctor->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('doctor.edit', encrypt($doctor->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('doctor.delete', encrypt($doctor->id)) }}" class="text-danger dlt">Delete</a>
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