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

        @if($modo !== 'pdf')
        <form method="POST" action="{{ route('formulario.pdf') }}">
        @csrf
        @endif

        <div class="hoja">
            @if($modo === 'pdf')
                <img src="{{ public_path('images/plantilla.png') }}" class="fondo">
            @else
                <img src="{{ asset('images/plantilla.png') }}" class="fondo">
            @endif

            @if($modo === 'pdf')
                <div class="Purchase_Order_PDF">
                    {{ $purchase_order ?? '' }}
                </div>
            @else
                <input
                    type="text"
                    name="purchase_order"
                    class="Purchase_Order"
                    value="{{ old('purchase_order', $purchase_order ?? '') }}"
                    placeholder="Purchase Order"
                >
            @endif
                        @if($modo === 'pdf')
                <div class="Material_Number_PDF">
                    {{ $material_number ?? '' }}
                </div>
            @else
                <input
                    type="text"
                    name="material_number"
                    class="Material_Number"
                    value="{{ old('material_number', $material_number ?? '') }}"
                    placeholder="Material Number"
                >
            @endif
        </div>

        @if($modo !== 'pdf')
            <button type="submit" class="Descargar">Descargar PDF</button>
        </form>
        @endif


</body>
</html>
