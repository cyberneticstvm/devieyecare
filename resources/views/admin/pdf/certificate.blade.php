@extends("admin.pdf.base")
@section("pdfContent")
<div class="row">
    <div class="col">
        <h4 class="text-center">EYE FITNESS CERTIFICATE</h4>
    </div>
    <div class="col mt-30">
        <h3>To whom it may concern</h3>
        -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        <br>
        <h4 class="text-center">STANDARDS OF VISION</h4>
        <br>
        <table width="100%">
            <thead>
                <tr>
                    <th width="50%" class="no-border text-center">RIGHT EYE</th>
                    <th width="50%" class="no-border text-center">LEFT EYE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no-border">1. DISTANT VISION .............................................. SNELLEN</td>
                    <td class="no-border text-end"> ...........................................................SNELLEN</td>
                </tr>
                <br>
                <tr>
                    <td class="no-border">2. NEAR VISION .............................................. SNELLEN</td>
                    <td class="no-border text-end"> ...........................................................SNELLEN</td>
                </tr>
                <br>
                <tr>
                    <td class="no-border" colspan="2" style="line-height: 2;">3. FIELD OF VISION ................................................................................... (Specify whether full or not. Entry such as 'NORMAL', 'GOOD' etc. will be in appropriate here.)</td>
                </tr>
                <br>
                <tr>
                    <td class="no-border" colspan="2">4. COLOUR BLINDNESS ...................................................................................</td>
                </tr>
                <br>
                <tr>
                    <td class="no-border" colspan="2">5. SQUINT ..................................................................................</td>
                </tr>
                <br>
                <tr>
                    <td class="no-border" colspan="2">6. ANY MORBID CONDITIONS OF THE EYE LIDS OF EITHER EYE:</td>
                </tr>
                <br>
                <tr>
                    <td class="no-border" colspan="2" style="line-height: 2;">
                        I HAVE THIS DAY, MEDICALLY EXAMINED SRI./SMT./KUMARI <strong>{{ $registration->name }}</strong> AGE <strong>{{ $registration->age }}</strong>
                        AND FOUND THAT HE/SHE HAS NO EYE ISSUES WHICH WOULD RENDER HIM/HER UNSUITABLE FOR ................................................................................................... JOB STATEMENT
                    </td>
                </tr>
                <br>
                <tr>
                    <td class="no-border">Place: {{ $registration->address }}<br><br>Date: {{ $registration->created_at->format('d.M.Y') }}</td>
                    <td class="no-border text-end">SIGNATURE</td>
                </tr>
                <br>
                <tr>
                    <td colspan="2" class="no-border text-end">{{ $registration->doctor->name }}<br><br> NAME AND DESIGNATION OF THE MEDICAL OFFICE</td>
                </tr>
                <br>
                <tr>
                    <td colspan="2" class="no-border">For<br>{{ $registration->name }}<br><br>---------------------------------------------------------------------------------<br>
                        <h4>DEVI EYE HOSPITALS</h4>
                    </td>
                </tr>
                <br>
            </tbody>
        </table>
    </div>
</div>
<footer>
    <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($registration->getMrn(), 'C39+', 1, 40, array(0,0,0), true) !!}" alt="{!! $registration->getMrn() !!}" />
    <div>Printed at: {{ date('d.M.Y h:i a') }}</div>
</footer>
@endsection