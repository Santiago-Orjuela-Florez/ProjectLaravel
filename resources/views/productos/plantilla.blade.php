<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Productos</title>

    @php
        // Aseguramos que modo siempre tenga un valor para evitar errores
        $modo = $modo ?? 'web';
    @endphp

    {{-- Carga de estilos según el modo --}}
    @if($modo === 'pdf')
        <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/plantilla.css') }}">
    @endif
    @if($modo !== 'pdf')
        <script src="{{ asset('js/consultas.js') }}?v={{ time() }}"></script>
    @endif
</head>

<body>

    {{-- 1. Recuadro de errores (Solo visible en la Web) --}}
    @if ($errors->any() && $modo !== 'pdf')
        <div
            style="background: #f8d7da; color: #721c24; padding: 15px; margin: 20px; border: 1px solid #f5c6cb; border-radius: 5px; font-family: sans-serif;">
            <strong>¡Atención! Revisa los siguientes campos:</strong>
            <ul style="margin-top: 5px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 2. Apertura del Formulario (Solo en la Web) --}}
    @if($modo !== 'pdf')
        <form method="POST" action="{{ route('formulario.pdf') }}">
            @csrf
    @endif

        <div class="hoja">
            {{-- Imagen de fondo --}}
            @if($modo === 'pdf')
                <img src="{{ public_path('images/plantilla.png') }}" class="fondo">
            @else
                <img src="{{ asset('images/plantilla.png') }}" class="fondo">
            @endif

            {{-- Campo: Purchase Order --}}
            @if($modo === 'pdf')
                <div class="Purchase_Order_PDF">{{ $purchase_order ?? '' }}</div>
            @else
                <input type="number" name="purchase_order" class="Purchase_Order"
                    value="{{ old('purchase_order', $purchase_order ?? '') }}" placeholder="Purchase Order">
            @endif

            {{-- Campo: Material Number --}}
            @if($modo === 'pdf')
                <div class="Material_Number_PDF">{{ $material_number ?? '' }}</div>
            @else
                <input type="number" name="material_number" class="Material_Number"
                    value="{{ old('material_number', $material_number ?? '') }}" placeholder="Material Number">
            @endif

            {{-- Campo: EAN --}}
            @if($modo === 'pdf')
                <div class="EAN_PDF">{{ $ean ?? '' }}</div>
            @else
                <input type="number" name="ean" class="EAN" value="{{ old('ean', $ean ?? '') }}" placeholder="EAN">
            @endif

            {{-- Campo: Delivery Date --}}
            @if($modo === 'pdf')
                <div class="Delivery_Date_PDF">{{ $delivery_date ?? '' }}</div>
            @else
                <input type="date" name="delivery_date" class="Delivery_Date"
                    value="{{ old('delivery_date', $delivery_date ?? '') }}">
            @endif

            {{-- Campo: Dropdown Nombres --}}
            <div class="nombres">
                @if($modo === 'pdf')
                    <span>{{ $nombre_seleccionado ?? '' }}</span>
                @else
                    <select name="nombre_seleccionado" class="desplegable">
                        <option value="">Select Name</option>
                        <option value="Andres Orjuela" {{ old('nombre_seleccionado') == 'Andres Orjuela' ? 'selected' : '' }}>
                            Andres Orjuela</option>
                        <option value="Santiago Orjuela" {{ old('nombre_seleccionado') == 'Santiago Orjuela' ? 'selected' : '' }}>Santiago Orjuela</option>
                        <option value="Camila Orjuela" {{ old('nombre_seleccionado') == 'Camila Orjuela' ? 'selected' : '' }}>
                            Camila Orjuela</option>
                    </select>
                @endif
            </div>

            {{-- Campo: Batch --}}
            @if($modo === 'pdf')
                <div class="Batch_PDF">{{ $batch ?? '' }}</div>
            @else
                <input type="number" name="batch" class="Batch" value="{{ old('batch', $batch ?? '') }}"
                    placeholder="Batch">
            @endif

            {{-- Campo: Quantity (Lógica de Base de Datos) --}}
            @if($modo === 'pdf')
                <div class="Quantity_PDF">
                    {{-- Prioridad: 1. Suma de DB, 2. Input manual, 3. Cero --}}
                    {{ $result->total_quantity ?? ($quantity ?? '0') }}
                </div>
            @else
                <input type="number" name="quantity" class="Quantity" value="{{ old('quantity', $quantity ?? '') }}"
                    placeholder="Quantity">
            @endif

            {{-- Campo: Batches (Texto adicional) --}}
            @if($modo === 'pdf')
                <div class="batches_PDF">{{ $batches ?? '' }}</div>
            @else
                <input type="text" name="batches" class="batches" value="{{ old('batches', $batches ?? '') }}"
                    placeholder="Extra Batches Info">
            @endif

            {{-- Ejemplo de dato extraído de la consulta (Opcional) --}}
            @if($modo === 'pdf' && isset($result->material_description))
                <div class="Descripcion_PDF" style="position:absolute; top: 200mm; left: 20mm;">
                    {{ $result->material_description }}
                </div>
            @endif
        </div>

        @if($modo !== 'pdf')
                <button type="submit" class="Descargar">Generar y Descargar PDF</button>
                <button type="button" id="btn_consultar" data-url="{{ route('datos.buscar') }}" data-token="{{ csrf_token() }}"
                    class="btn-consultar">
                    Consultar Datos
                </button>
            </form>
        @endif
 
</body>

</html>