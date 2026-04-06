<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lens Envelop</title>
    <style>
        @page {
            margin-top: 5cm;
            margin-right: 5cm;
            /* ← 3cm Top Margin as requested */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px 25px;
            background: white;
            color: #000;
            line-height: 1.2;
        }

        .container {
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
            padding: 15px;
            position: relative;
        }

        .order-no {
            font-size: 28px;
            font-weight: bold;
            text-align: right;
            margin-bottom: 15px;
            color: #000;
        }

        .prescription {
            font-size: 22px;
            margin: 15px 0;
            line-height: 1.4;
        }

        .lens-info {
            font-size: 26px;
            font-weight: bold;
            margin: 20px 0 10px;
        }

        .barcode-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .barcode {
            font-family: monospace;
            font-size: 18px;
            letter-spacing: 2px;
        }

        .qr-code {
            text-align: right;
        }

        .footer-text {
            font-size: 9px;
            line-height: 1.1;
            margin-top: 15px;
            border-top: 1px solid #000;
            padding-top: 8px;
        }

        .ce {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .symbols {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Order Number -->
        <div class="order-no"></div>

        <!-- Prescription -->
        <div class="prescription" style="margin-left: 30%;">
            <strong>s. {{ $stock->sph }} c. {{ $stock->cyl }} x. {{ $stock->axis }} {{ $stock->add }}</strong><br>
            <strong>s. {{ $stock->sph }} c. {{ $stock->cyl }} x. {{ $stock->axis }} {{ $stock->add }}</strong>
        </div>

        <!-- Lens Details -->
        <div class="lens-info" style="margin-left: 30%;">
            {{ $stock->material?->name }}
        </div>

        <div class="barcode-section">
            <!-- Barcode -->
            <div style="margin-left: 30%;">
                <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($stock->material->code, 'C39+', 1, 40, array(0,0,0), false) !!}" alt="{{ $stock->material->code }}" style="height: 30px;">
                <div class="barcode">{{ $stock->material->code }}</div>
            </div>

            <!-- QR Code -->
            <div class="qr-code">
                <img src="data:image/png;base64, {!! $qrcode !!}"
                    alt="QR Code" style="height: 50px; width: 50px;">
                <div style="font-size: 10px; margin-top: 5px;">{{ $stock->material->code }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-text" style="margin-left: 30%;">
            <strong>CE</strong>
            <span style="float: right; font-size: 10px;">Specially packed for exclusive use as raw material for spectacles<br>
                by opticians and not meant for retail sale in packaged condition.</span>

            <div style="margin-top: 15px; text-align: right; font-size: 11px;">
                <strong>Made in Taiwan</strong>
            </div>
        </div>
    </div>
</body>

</html>