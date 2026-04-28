@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Customer Order Register</h5>
        <p class="fs-12">Customer Order Register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Inv No</th>
                            <th class="py-2 fw-medium small text-uppercase">Order Id</th>
                            <th class="py-2 fw-medium small text-uppercase">Customer</th>
                            <th class="py-2 fw-medium small text-uppercase">Order Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Download</th>
                            <th class="py-2 fw-medium small text-uppercase">Edit</th>
                            <th class="py-2 fw-medium small text-uppercase">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td></td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order?->customer?->name}}</td>
                            <td>{{ $order->order_date->format('d.M.Y') }}</td>
                            <td>{!! $order->cancelled() !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Download
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" target="_blank">Delivery Order</a></li>
                                        <li><a class="dropdown-item" href="#" target="_blank">Invoice</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('drishti.customer.order.edit', encrypt($order->id)) }}" class="btn btn-link text-secondary">Edit</a> </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('drishti.customer.order.delete', encrypt($order->id)) }}" method="POST" style="display:inline;">
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