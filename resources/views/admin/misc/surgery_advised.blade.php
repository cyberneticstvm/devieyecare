@extends("admin.base")
@section("content")
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Surgery Advised Register</h5>
        <p class="fs-12">Showing Surgery Advised Register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Review</th>
                            <th class="py-2 fw-medium small text-uppercase">MRN</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Address</th>
                            <th class="py-2 fw-medium small text-uppercase">Mobile</th>
                            <th class="py-2 fw-medium small text-uppercase">Doctor</th>
                            <th class="py-2 fw-medium small text-uppercase">Branch</th>
                            <th class="py-2 fw-medium small text-uppercase">Pharma</th>
                            <th class="py-2 fw-medium small text-uppercase">Download</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $key => $reg)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('registration.create', ['rtype' => encrypt('Review'), 'typeid' => encrypt($reg->id)]) }}" data-toggle="tooltip" data-placement="top" title="Click here to review the patient">Review</a></td>
                            <td><a href="{{ route('store.order.edit', ['rid' => encrypt($reg->id), 'source' => 'registration']) }}" data-toggle="tooltip" data-placement="top" title="Click here to make an Order">{{ $reg->getMrn() }}</a></td>
                            <td>{{ $reg->name }}</td>
                            <td>{{ $reg->address }}</td>
                            <td>{{ $reg->mobile }}</td>
                            <td>{{ $reg->doctor->name }}</td>
                            <td>{{ $reg->branch->name }}</td>
                            <td><a href="{{ route('pharmacy.order.create', encrypt($reg->id)) }}" data-toggle="tooltip" data-placement="top" title="Click here to make Pharmacy Order">Prescription</a></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Download
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">OPT</a></li>
                                        <li><a class="dropdown-item" href="#">Order Receipt</a></li>
                                        <li><a class="dropdown-item" href="#">Service Fee Receipt</a></li>
                                        <li><a class="dropdown-item" href="#">Pharmacy Receipt</a></li>
                                        <li><a class="dropdown-item" href="#">Certificate</a></li>
                                        <li><a class="dropdown-item" href="#">Envelope</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $reg->ostatus->name }}</td>
                            <td>{!! $reg->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('registration.edit', encrypt($reg->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('registration.delete', encrypt($reg->id)) }}" class="text-danger dlt">Delete</a>
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