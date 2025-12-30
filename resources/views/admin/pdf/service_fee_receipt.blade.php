@extends("admin.pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <h4 class="text-center">RECEIPT</h4>
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
                    Consultant: {{ $registration->doctor->name }}, {{ $registration->doctor->qualification }}
                </td>
            </tr>
            <tr>
                <td class="no-border" colspan="2">
                    Address & Contact: {{ $registration->address }}, {{ $registration->mobile }}
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <table width=100%>
        <thead>
            <tr>
                <th width="10%" class="no-border">SL No.</th>
                <th width="70%" class="no-border">Item Description</th>
                <th width="20%" class="no-border text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no-border">1</td>
                <td class="no-border">Doctor Fee Collected</td>
                <td class="no-border text-end">{{ $registration->doc_fee }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="no-border" colspan="3">
                    <hr>
                </td>
            </tr>
            <tr>
                <th colspan="2" class="text-end no-border">Total</th>
                <th class="text-end no-border">{{ $registration->doc_fee }}</th>
            </tr>
        </tfoot>
    </table>
    </br>
    <div class="">
        Phone: 9544892622 / 9400571622 <small>Please bring this slip at the time of delivery/ Please note that we will not responsible for any damage while fitting the lens on customer's frame / To be billed after approval / In case of any complaints or suggestions please call 99 95 27 30 40</small>
    </div>
</div>
<footer>
    <small>Printed at: {{ date('d.M.Y h:i a') }}</small>
</footer>
@endsection