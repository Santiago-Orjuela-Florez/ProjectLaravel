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

            {{-- Campo Pallestisation --}}
            @if($modo === 'pdf')
                <div class="Pallets_PDF">{{ $pallets ?? '' }}</div>
                <div class="Units_PDF">{{ $units ?? '' }}</div>
                <div class="Pallets2_PDF">{{ $pallets2 ?? '' }}</div>
                <div class="Units2_PDF">{{ $units2 ?? '' }}</div>
            @else
                <div class="Pallestisation">
                    <input type="number" name="pallets" class="Pallets" value="{{ old('pallets', $pallets ?? '') }}"
                        placeholder="Pallets">
                    <input type="number" name="units" class="Units" value="{{ old('units', $units ?? '') }}"
                        placeholder="Units">
                    <input type="number" name="pallets2" class="Pallets2" value="{{ old('pallets2', $pallets2 ?? '') }}"
                        placeholder="Pallets">
                    <input type="number" name="units2" class="Units2" value="{{ old('units2', $units2 ?? '') }}"
                        placeholder="Units">
                </div>
            @endif

            {{-- Campo: Delivery Date --}}
            @if($modo === 'pdf')
                <div class="Delivery_Date_PDF">{{ $delivery_date ?? '' }}</div>
            @else
                <input type="date" name="delivery_date" class="Delivery_Date"
                    value="{{ old('delivery_date', $delivery_date ?? '') }}">
            @endif

            {{-- Manufacturing Date --}}
            @if($modo === 'pdf')
                <div class="Manufacturing_Date_PDF">{{ $manufacturing_date ?? '' }}</div>
            @else
                <input type="date" name="manufacturing_date" class="Manufacturing_Date"
                    value="{{ $manufacturing_date ?? '' }}">
            @endif


            {{-- Best Before Date --}}
            @if($modo === 'pdf')
                <div class="Best_Before_Date_PDF">{{ $best_before_date ?? '' }}</div>
            @else
                <input type="date" name="best_before_date" class="Best_Before_Date" value="{{ $best_before_date ?? '' }}">
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
        
            {{-- Campos Checkbox --}}
            @if($modo === 'pdf')
                {{-- Validamos: Check (✓) o Fallo (X) --}}
                @if(isset($inspeccion) && is_array($inspeccion))
                    @if(in_array('01', $inspeccion))
                        <div class="Check_01_PDF" style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('01', $fallos)) <div class="Check_01_PDF">X</div>
                    @endif

                    @if(in_array('02', $inspeccion))
                        <div class="Check_02_PDF" style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('02', $fallos)) <div class="Check_02_PDF">X</div>
                    @endif

                    @if(in_array('03', $inspeccion))
                        <div class="Check_03_PDF" style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('03', $fallos)) <div class="Check_03_PDF">X</div>
                    @endif

                    @if(in_array('04', $inspeccion))
                        <div class="Check_04_PDF" style="font-family: 'DejaVu Sans', sans-serif;">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('04', $fallos)) <div class="Check_04_PDF">X</div>
                    @endif
                @elseif(isset($fallos) && is_array($fallos))
                    // Caso borde: solo hay fallos marcados y ningun check
                    @if(in_array('01', $fallos))
                    <div class="Check_01_PDF">X</div> @endif
                    @if(in_array('02', $fallos))
                    <div class="Check_02_PDF">X</div> @endif
                    @if(in_array('03', $fallos))
                    <div class="Check_03_PDF">X</div> @endif
                    @if(in_array('04', $fallos))
                    <div class="Check_04_PDF">X</div> @endif
                @endif
            @else
                <div class="checkboxes">
                    <div class="item-chequeo">
                        <span style="font-size: 12px; margin-right: 5px;">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="01" id="check01">
                        <label for="check01" style="margin-right: 10px;"></label>

                        <span style="font-size: 12px; margin-right: 5px;">X</span>
                        <input type="checkbox" name="fallos[]" value="01" id="fail01">
                        <label for="fail01"></label>
                    </div>

                    <div class="item-chequeo">
                        <span style="font-size: 12px; margin-right: 5px;">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="02" id="check02">
                        <label for="check02" style="margin-right: 10px;"></label>

                        <span style="font-size: 12px; margin-right: 5px;">X</span>
                        <input type="checkbox" name="fallos[]" value="02" id="fail02">
                        <label for="fail02"></label>
                    </div>

                    <div class="item-chequeo">
                        <span style="font-size: 12px; margin-right: 5px;">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="03" id="check03">
                        <label for="check03" style="margin-right: 10px;"></label>

                        <span style="font-size: 12px; margin-right: 5px;">X</span>
                        <input type="checkbox" name="fallos[]" value="03" id="fail03">
                        <label for="fail03"></label>
                    </div>

                    <div class="item-chequeo">
                        <span style="font-size: 12px; margin-right: 5px;">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="04" id="check04">
                        <label for="check04" style="margin-right: 10px;"></label>

                        <span style="font-size: 12px; margin-right: 5px;">X</span>
                        <input type="checkbox" name="fallos[]" value="04" id="fail04">
                        <label for="fail04"></label>
                    </div>
                </div>
            @endif


            {{-- Campo: Batches (Texto adicional) --}}
            @if($modo === 'pdf')
                <div class="batches_PDF">{{ $batches ?? '' }}</div>
            @else
                <input type="text" name="batches" class="batches" value="{{ old('batches', $batches ?? '') }}"
                    placeholder="Extra Batches Info">
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