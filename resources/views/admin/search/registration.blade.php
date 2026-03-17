@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Search Registration</h5>
        <p class="fs-12">Search Registration</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-6">
                {{ html()->form('POST')->route('search.registration.show')->class('d-flex')->attribute('role', 'search')->open() }}
                {{ html()->text('search_term', $inputs[0] ?? old('search_term'))->class('form-control me-2')->attribute('id', 'navbarSearch')->placeholder('Name / Mobile / Mrn') }}
                {{ html()->select('search_type', array('new' => 'New', 'old' => 'Old'), $inputs[1] ?? old('search_type'))->class('form-control me-2')->attribute('id', 'search_type') }}
                {{ html()->submit('Search')->class('btn btn-submit btn-primary w-100') }}
                {{ html()->form()->close() }}
                @error('search_term')
                <small class="text-danger">{{ $errors->first('search_term') }}</small>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Registration List</h5>
        <p class="fs-12">Showing registrations for search</p>
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
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    @if($inputs[1] == "new")
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
                            <td><a href="{{ route('registration.create', ['rtype' => encrypt('Review'), 'typeid' => encrypt($reg->id)]) }}" data-toggle="tooltip" data-placement="top" title="Click here to make Pharmacy Order">Prescription</a></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Download
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('opt', ['registration_id' => encrypt($reg->id)]) }}" target="_blank">OPT</a></li>
                                        <li><a class="dropdown-item" href="{{ route('store.order.receipt', ['registration_id' => encrypt($reg->id)]) }}" target="_blank">Order Receipt</a></li>
                                        <li><a class="dropdown-item" href="{{ route('invoice', ['registration_id' => encrypt($reg->id)]) }}" target="_blank">Invoice</a></li>
                                        <li><a class="dropdown-item" href="{{ route('service.fee.receipt', ['registration_id' => encrypt($reg->id)]) }}" target="_blank">Service Fee Receipt</a></li>
                                        <li><a class="dropdown-item" href="{{ route('pharmacy.order.receipt', ['registration_id' => encrypt($reg->id)]) }}" target="_blank">Pharmacy Receipt</a></li>
                                        <li><a class="dropdown-item" href="{{ route('certificate', ['registration_id' => encrypt($reg->id)]) }}" target="_blank">Certificate</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>{!! $reg->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('registration.edit', encrypt($reg->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('registration.delete', encrypt($reg->id)) }}" class="text-danger dlt">Delete</a>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    @else
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td></td>
                            <td><a class="oldOrderDrawer" data-bs-toggle="offcanvas" href="#oldOrderDetails" role="button" aria-controls="oldOrderDetails">{{ $registrations['mrn'] }}</a></td>
                            <td>{{ $registrations['name'] }}</td>
                            <td>{{ $registrations['address'] }}</td>
                            <td>{{ $registrations['mobile'] }}</td>
                            <td>{{ $registrations['doctor'] }}</td>
                            <td>{{ $registrations['branch'] }}</td>
                            <td>{{ $registrations['medicine'] }}</td>
                            <td></td>
                            <td>{{ $registrations['status'] }}</td>
                            <td><a href="https://login.devieyecare.com/registration.php?reg_id={{ $registrations['reg_id'] }}" target="_blank">Edit</a></td>
                        </tr>
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@include("admin.misc.drawer.old_order_details")
@endsection