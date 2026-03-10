<!DOCTYPE html>
<html>

<head>
    <title>Devi Eye Hospitals and Opticians</title>
    <style>
        .font-big {
            font-size: 25px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-end {
            text-align: right;
        }

        .vertical-barcode {
            transform: rotate(90deg);
            margin-right: -75px;
        }

        .qrcode {
            margin-right: 50px;
            margin-top: -15px;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="font-big fw-bold">{{ $stock->eye }}&nbsp;&nbsp;&nbsp;{{ $stock->sph }}&nbsp;&nbsp;&nbsp;{{ $stock->cyl }}&nbsp;&nbsp;&nbsp;X {{ $stock->axis }}&nbsp;&nbsp;&nbsp;{{ $stock->add }} A</div>
    <div class="font-big fw-bold">{{ $stock->material?->name }}</div>
    <div class="text-end"><img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($stock->material->code, 'C39+', 1, 40, array(0,0,0), false) !!}" alt="{{ $stock->material->code }}" class="vertical-barcode" /></div>
    <div class="text-end qrcode"><img src="data:image/png;base64, {!! $qrcode !!}"></div>
</body>

</html>