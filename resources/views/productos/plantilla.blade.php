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
                <input type="number" name="purchase_order" class="Purchase_Order"
                    value="{{ old('purchase_order', $purchase_order ?? '') }}" placeholder="Purchase Order" required>
            @endif
            @if($modo === 'pdf')
                <div class="Material_Number_PDF">
                    {{ $material_number ?? '' }}
                </div>
            @else
                <input type="number" name="material_number" class="Material_Number"
                    value="{{ old('material_number', $material_number ?? '') }}" placeholder="Material Number" required>
            @endif
            @if($modo === 'pdf')
                <div class="EAN_PDF">
                    {{ $ean ?? '' }}
                </div>
            @else
                <input type="number" name="ean" class="EAN" value="{{ old('ean', $ean ?? '') }}" placeholder="EAN" required>
            @endif

            @if($modo === 'pdf')
                <div class="Delivery_Date_PDF">
                    {{ $delivery_date ?? '' }}
                </div>
            @else
                <input type="date" name="delivery_date" class="Delivery_Date"
                    value="{{ old('delivery_date', $delivery_date ?? '') }}" placeholder="Delivery Date" required>
            @endif

            <div class="nombres">
                @if($modo === 'pdf')
                    {{-- En el PDF solo se muestra el texto seleccionado --}}
                    <span>{{ $nombre_seleccionado ?? '' }}</span>
                @else
                    {{-- En la Web se muestra la lista desplegable --}}
                    <select name="nombre_seleccionado" class="desplegable">
                        <option value="">Select Name</option>
                        <option value="Andres Orjuela">Andres Orjuela</option>
                        <option value="Santiago Orjuela">Santiago Orjuela</option>
                        <option value="Camila Orjuela">Camila Orjuela</option>
                    </select>
                @endif
            </div>

            @if($modo === 'pdf')
                <div class="Batch_PDF">
                    {{ $batch ?? '' }}
                </div>
            @else
                <input type="number" name="batch" class="Batch" value="{{ old('batch', $batch ?? '') }}" placeholder="Batch"
                    required>
            @endif

            @if($modo === 'pdf')
                <div class="Quantity_PDF">
                    {{ $quantity ?? '' }}
                </div>
            @else
                <input type="number" name="quantity" class="Quantity" value="{{ old('quantity', $quantity ?? '') }}"
                    placeholder="Quantity" required>
            @endif
        </div>

        @if($modo !== 'pdf')
                <button type="submit" class="Descargar">Descargar PDF</button>
            </form>
        @endif


</body>

</html>