@extends("admin.pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <h4 class="text-center">BILL OF SUPPLY</h4>
        <p class="text-center">Composition taxable person. Not eligible to collect tax on supplies</p>
        <table width=100%>
            <tr>
                <td class="no-border" width="50%">
                    MRN: {!! $registration->getMrn() !!}
                </td>
                <td class="no-border text-end">
                    Date: {{ $registration->created_at->format('d.M.Y h:i a') }}
                </td>
            </tr>
            <tr>
                <td class="no-border">
                    Name: {{ strtoupper($registration->name) }} | {{ $registration->getAge() }} Y | {{ $registration->gender }}
                </td>
                <td class="no-border text-end">
                    GSTIN: {{ $registration->branch->gstin }}, State Name: Kerala, Code: 32
                </td>
            </tr>
            <tr>
                <td class="no-border">
                    Address & Contact: {{ $registration->address }}, {{ $registration->mobile }}
                </td>
                <td class="no-border text-end">
                    DL No:
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <table width=100%>
        <thead>
            <tr>
                <th width="10%" class="no-border">SL No.</th>
                <th width="30%" class="no-border">Item Description</th>
                <th width="10%" class="no-border">HSN</th>
                <th width="10%" class="no-border">Batch</th>
                <th width="10%" class="no-border">Qty</th>
                <th width="10%" class="no-border">Rate</th>
                <th width="20%" class="no-border text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            @if($registration->pharmacy)
            @forelse($registration->pharmacy?->details as $key => $item)
            <tr>
                <td class="no-border">{{ $key + 1 }}</td>
                <td class="no-border">{{ $item->product->name }}</td>
                <td class="no-border">{{ $item->product->hsn->code }}</td>
                <td class="no-border">{{ $item->batch }}</td>
                <td class="no-border">{{ $item->qty }}</td>
                <td class="no-border text-end">{{ $item->price }}</td>
                <td class="no-border text-end">{{ $item->total }}</td>
            </tr>
            @empty
            @endforelse
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="no-border" colspan="7">
                    <hr>
                </td>
            </tr>
            <tr>
                <th colspan="6" class="text-end no-border">Discount</th>
                <th class="text-end no-border">{{ $registration->pharmacy?->discount ?? 0.00 }}</th>
            </tr>
            <tr>
                <th colspan="6" class="text-end no-border">Total</th>
                <th class="text-end no-border">{{ $registration->pharmacy?->total ?? 0.00 }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="">
        <p>Declaration</p>
        <small>We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct. Composition taxable person. Not eligible to collect tax on supplies</small>
    </div>
    <div class="text-end">
        <h5>for DEVI OPTICIANS</h5>
        <p>Authorised Signatory</p>
    </div>
</div>
<footer>
    <small>This is a Computer Generated Invoice, Printed at: {{ date('d.M.Y h:i a') }}</small>
</footer>
@endsection