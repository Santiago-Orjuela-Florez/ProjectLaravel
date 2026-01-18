<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    @php
        $modo = $modo ?? 'web';
    @endphp

    @if($modo === 'pdf')
        <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
    @endif

    <title>Formulario</title>
</head>
<body>

<div class="hoja">
    @if($modo === 'pdf')
        <img src="{{ public_path('images/plantilla.png') }}" class="fondo">
    @else
        <img src="{{ asset('images/plantilla.png') }}" class="fondo">
    @endif

    @if($modo === 'pdf')
        <div class="Purchase_Order_PDF" >{{ $purchase_order ?? '' }}</div>
    @else
        <input type="text" class="Purchase_Order" value="{{ $purchase_order ?? '' }}" placeholder="Purchase Order">
    @endif
</div>

</body>
</html>
