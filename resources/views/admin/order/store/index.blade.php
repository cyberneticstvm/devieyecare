@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Store Order Register</h5>
        <p class="fs-12">Showing today's orders</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">MRN</th>
                            <th class="py-2 fw-medium small text-uppercase">Invoice</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Address</th>
                            <th class="py-2 fw-medium small text-uppercase">Mobile</th>
                            <th class="py-2 fw-medium small text-uppercase">Branch</th>
                            <th class="py-2 fw-medium small text-uppercase">Download</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Cancelled</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{!! $order->registration->getMrn() !!}</td>
                            <td>{!! $order->ino() !!}</td>
                            <td>{{ $order->registration->name }}</td>
                            <td>{{ $order->registration->address }}</td>
                            <td>{{ $order->registration->mobile }}</td>
                            <td>{{ $order->branch->name }}</td>
                            <td></td>
                            <td class="text-primary"><a class="orderStatusUpdateDrawer" data-bs-toggle="offcanvas" href="#OrderStatusSettings" role="button" aria-controls="OrderStatusSettings" aria-label="thunder AI theme setting" data-mrn="{!! $order->registration->getMrn() !!}" data-oid="{{ encrypt($order->id) }}">{{ $order->ostatus()->latest()->first()->status->name }}</a></td>
                            <td>{!! $order->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('store.order.edit', ['rid' => encrypt($order->id), 'source' => 'order']) }}" class="text-secondary">Edit</a> | <a href="{{ route('store.order.delete', encrypt($order->id)) }}" class="text-danger dlt">Delete</a>
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
<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="OrderStatusSettings">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Update Order Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pe-4">
        <div class="px-lg-2 mb-4">
            <h6 class="small text-uppercase mrn"></h6>
            {{ html()->form('POST')->route('store.order.status.update')->open() }}
            <input type="hidden" name="oid" id="oid" value="" />
            <div class="row g-3">
                <div class="control-group col-md-12">
                    <label class="form-label req">Order Status </label>
                    {{ html()->select('status', $statuses, '')->class('form-control')->placeholder('Select')->required() }}
                </div>
            </div>
            <div class="raw mt-3">
                <div class="col text-end">
                    {{ html()->submit('Update')->class('btn btn-submit btn-primary') }}
                </div>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endsection