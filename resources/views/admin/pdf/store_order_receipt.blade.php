@extends("admin.pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <h4 class="text-center">ORDER RECEIPT</h4>
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
                    Due Date: {{ $registration->order?->due_date?->format('d.M.Y') }}
                </td>
            </tr>
            <tr>
                <td class="no-border">
                    Address & Contact: {{ $registration->address }}, {{ $registration->mobile }}
                </td>
                <td class="no-border text-end">
                    Consultant: {{ $registration->doctor->name.', '.$registration->doctor->qualification}}
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <div class="col">
        <h5 class="">PRESCRIPTION / LENS DETAILS</h5>
        <table width=100%>
            <thead>
                <tr>
                    <th width="10%" class="no-border">SL No.</th>
                    <th width="30%" class="no-border">Item Description</th>
                    <th width="10%" class="no-border">HSN</th>
                    <th width="10%" class="no-border">Qty</th>
                    <th width="10%" class="no-border">Rate</th>
                    <th width="20%" class="no-border text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if($registration->order)
                @forelse($registration->order?->details as $key => $item)
                <tr>
                    <td class="no-border">{{ $key + 1 }}</td>
                    <td class="no-border">{{ $item->product->name }}</td>
                    <td class="no-border">{{ $item->product->hsn->code }}</td>
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
                    <td class="no-border" colspan="6">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th colspan="3" class="no-border">Total: {{ $registration->order?->total ?? 0.00 }}</th>
                    <th colspan="2" class="text-end no-border">Discount</th>
                    <th class="text-end no-border">{{ $registration->order?->discount ?? 0.00 }}</th>
                </tr>
                <tr>
                    <th colspan="3" class="no-border">Advance: {{ $registration->order?->advance ?? 0.00 }}</th>
                    <th colspan="2" class="text-end no-border">Balance</th>
                    <th class="text-end no-border">{{ number_format($registration->order?->total - $registration->order?->advance, 2) }}</th>
                </tr>
            </tfoot>
        </table>
        <p>Phone: 0470 2624622 / 8089424622 Please bring this slip at the time of delivery/ Please note that we will not responsible for any damage while fitting the lens on customer's frame / To be billed after approval / In case of any complaints or suggestions please call 99 95 27 30 40.</p>
        <div class="text-center">This is a Computer Generated Receipt, Printed at: {{ date('d.M.Y h:i a') }}</div>
    </div>
    <div class="mb-10">
        -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    </div>
    <div class="col">
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
                    Due Date: {{ $registration->order?->due_date?->format('d.M.Y') }}
                </td>
            </tr>
            <tr>
                <td class="no-border">
                    Address & Contact: {{ $registration->address }}, {{ $registration->mobile }}
                </td>
                <td class="no-border text-end">
                    Consultant: {{ $registration->doctor->name.', '.$registration->doctor->qualification}}
                </td>
            </tr>
        </table>
        <table width=100% class="mt-10">
            <thead>
                <tr>
                    <th width="5%" class="no-border">EYE</th>
                    <th width="5%" class="no-border">SPH</th>
                    <th width="5%" class="no-border">CYL</th>
                    <th width="5%" class="no-border">AXIS</th>
                    <th width="5%" class="no-border">ADD</th>
                    <th width="5%" class="no-border">DIA</th>
                    <th width="5%" class="no-border">IPD</th>
                    <th width="15%" class="no-border">THICK</th>
                    <th width="25%" class="no-border">Item Description</th>
                    <th width="5%" class="no-border">Qty</th>
                    <th width="10%" class="no-border">Rate</th>
                    <th width="10%" class="no-border text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if($registration->order)
                @forelse($registration->order?->details as $key => $item)
                <tr>
                    <td class="no-border">{{ $item->eye }}</td>
                    <td class="no-border">{{ $item->sph }}</td>
                    <td class="no-border">{{ $item->cyl }}</td>
                    <td class="no-border">{{ $item->axis }}</td>
                    <td class="no-border">{{ $item->addition }}</td>
                    <td class="no-border">{{ $item->dia }}</td>
                    <td class="no-border">{{ $item->ipd }}</td>
                    <td class="no-border">{{ $item->thickness?->name }}</td>
                    <td class="no-border">{{ $item->product->name }}</td>
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
                    <td class="no-border" colspan="12">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th colspan="9" class="no-border">Total: {{ $registration->order?->total ?? 0.00 }}</th>
                    <th colspan="2" class="text-end no-border">Discount</th>
                    <th class="text-end no-border">{{ $registration->order?->discount ?? 0.00 }}</th>
                </tr>
                <tr>
                    <th colspan="9" class="no-border">Advance: {{ $registration->order?->advance ?? 0.00 }}</th>
                    <th colspan="2" class="text-end no-border">Balance</th>
                    <th class="text-end no-border">{{ number_format($registration->order?->total - $registration->order?->advance, 2) }}</th>
                </tr>
                <tr>
                    <th colspan="5" class="no-border">Advisor: {{ $registration->order?->advisor?->name }}</th>
                    <th colspan="6" class="no-border">Remarks: {{ $registration->order?->remarks }}</th>
                </tr>
            </tfoot>
        </table>
        <div class="text-center">
            <img src="./assets/images/lab-copy.png" />
        </div>
    </div>
</div>
<footer>
    <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($registration->getMrn(), 'C39+', 1, 40, array(0,0,0), true) !!}" alt="{!! $registration->getMrn() !!}" />
    <div>This is a Computer Generated Receipt, Printed at: {{ date('d.M.Y h:i a') }}</div>
</footer>
@endsection