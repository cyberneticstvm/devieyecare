@extends("admin.pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <h4 class="text-center">OUT PATIENT RECORD</h4>
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
        </table>
    </div>
    <hr>
    <div class="col">
        <table width=100%>
            <tr>
                <td class="no-border" width="100%" colspan="2">
                    History:
                    <pre>
                    <pre>
                </td>
            </tr>
            <tr>
                <td class="no-border" width="50%">
                    RE:
                    <pre>
                    <pre>
                    <pre>
                    <pre>
                </td>
                <td class="no-border" width="50%">
                    LE:
                    <pre>
                    <pre>
                    <pre>
                    <pre>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="no-border">Codes: BS, CNR, DCT, DIL, DS, EPLN, FB, I&C, IOP, LIC-LV, PB, PSR, RS, RW, VT</td>
            </tr>
            <tr>
                <td class="no-border" width="100%" colspan="2">
                    Provisional Diagnosis/Treatment:
                    <pre>
                    <pre>
                    <pre>
                    <pre>
                    <pre>
                    <pre>
                    <pre>
                    <pre>
                </td>
            </tr>
        </table>
    </div>
</div>
<footer>
    <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($registration->getMrn(), 'C39+', 1, 40, array(0,0,0), true) !!}" alt="{!! $registration->getMrn() !!}" />
    <div>Printed at: {{ date('d.M.Y h:i a') }}</div>
</footer>
@endsection