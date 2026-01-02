@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <div class="row">
            <div class="col col-sm-10">
                <h5 class="fw-medium text-uppercase mb-0">Product Register</h5>
                <p class="fs-12">Showing all products</p>
            </div>
            <div class="col col-sm-2 text-end">
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Export</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('product.export') }}"><i class="bi bi-file-earmark-excel text-success h4"></i>&nbsp;&nbsp;Excel</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-pdf text-danger h4"></i>&nbsp;&nbsp;Pdf</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">PID</th>
                            <th class="py-2 fw-medium small text-uppercase">Name</th>
                            <th class="py-2 fw-medium small text-uppercase">Code</th>
                            <th class="py-2 fw-medium small text-uppercase">Category</th>
                            <th class="py-2 fw-medium small text-uppercase">HSN</th>
                            <th class="py-2 fw-medium small text-uppercase">Manufacturer</th>
                            <th class="py-2 fw-medium small text-uppercase">Price</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->hsn->name }}</td>
                            <td>{{ $product->hsn->code }}</td>
                            <td>{{ $product->manufacturer?->name }}</td>
                            <td>{{ $product->selling_price }}</td>
                            <td>{!! $product->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('product.edit', encrypt($product->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('product.delete', encrypt($product->id)) }}" class="text-danger dlt">Delete</a>
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