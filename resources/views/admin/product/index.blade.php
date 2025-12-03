@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Product Register</h5>
        <p class="fs-12">Showing all products</p>
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
                            <td>{{ $product->manufacturer->name }}</td>
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