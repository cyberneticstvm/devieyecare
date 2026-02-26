@extends("admin.pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <h4 class="text-center">FOR LAB</h4>
    </div>
    <hr>
    <table width=100%>
        <thead>
            <tr>
                <th width="10%" class="no-border">SL No.</th>
                <th width="10%" class="no-border">Mrn</th>
                <th width="10%" class="no-border">Due Date</th>
                <th width="10%" class="no-border">Name</th>
                <th width="20%" class="no-border">Place</th>
                <th width="10%" class="no-border">Contact</th>
                <th width="10%" class="no-border">Status</th>
                <th width="20%" class="no-border">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $key => $order)
            <tr>
                <td class="no-border fw-bold">{{ $key + 1 }}</td>
                <td class="no-border fw-bold">{!! $order->registration->getMrn() !!}</td>
                <td class="no-border fw-bold">{{ $order->due_date?->format("d.M.Y") }}</td>
                <td class="no-border fw-bold">{{ $order->registration->name }}</td>
                <td class="no-border fw-bold">{{ $order->registration->address }}</td>
                <td class="no-border fw-bold">{{ $order->registration->mobile }}</td>
                <td class="no-border fw-bold">{{ $order->ostatus?->name }}</td>
                <td class="no-border fw-bold">{{ $order->remarks }}</td>
            </tr>
            <tr>
                <td colspan="8" class="text-center">
                    <table width="80%" class="mx-auto">
                        <tbody>
                            @forelse($order->details as $key1 => $item)
                            <tr>
                                <td class="no-border">{{ $item->eye }}</td>
                                <td class="no-border">{{ $item->sph }}</td>
                                <td class="no-border">{{ $item->cyl }}</td>
                                <td class="no-border">{{ $item->axis }}</td>
                                <td class="no-border">{{ $item->addition }}</td>
                                <td class="no-border">{{ $item->dia }}</td>
                                <td class="no-border">{{ $item->thickness?->name }}</td>
                                <td class="no-border">{{ $item->product->name }}</td>
                                <td class="no-border">{{ $item->qty }}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
<footer>
    <small>This is a Computer Generated Invoice, Printed at: {{ date('d.M.Y h:i a') }}</small>
</footer>
@endsection