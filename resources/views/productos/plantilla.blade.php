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
        <div class="alert-error">
            <strong>Attention! Check the following fields:</strong>
            <ul>
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



            {{-- Campo: Sign Warehouse --}}
            <div class="nombres">
                @if($modo === 'pdf')
                    <span>{{ $sign_warehouse ?? '' }}</span>
                @else
                    <select name="sign_warehouse" class="desplegable">
                        <option value="">Select Name</option>
                        <option value="Andres Orjuela" {{ old('sign_warehouse') == 'Andres Orjuela' ? 'selected' : '' }}>
                            Andres Orjuela</option>
                        <option value="Santiago Orjuela" {{ old('sign_warehouse') == 'Santiago Orjuela' ? 'selected' : '' }}>
                            Santiago Orjuela</option>
                        <option value="Camila Orjuela" {{ old('sign_warehouse') == 'Camila Orjuela' ? 'selected' : '' }}>
                            Camila Orjuela</option>
                    </select>
                @endif
            </div>

            {{-- Campo: Sign Inventory --}}
            <div class="inventory">
                @if($modo === 'pdf')
                    <span>{{ $sign_inventory ?? '' }}</span>
                @else
                    <select name="sign_inventory" class="desplegable">
                        <option value="">Select Name</option>
                        <option value="Andres Orjuela" {{ old('sign_inventory') == 'Andres Orjuela' ? 'selected' : '' }}>
                            Andres Orjuela</option>
                        <option value="Santiago Orjuela" {{ old('sign_inventory') == 'Santiago Orjuela' ? 'selected' : '' }}>
                            Santiago Orjuela</option>
                        <option value="Camila Orjuela" {{ old('sign_inventory') == 'Camila Orjuela' ? 'selected' : '' }}>
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
                        <div class="Check_01_PDF font-dejavu">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('01', $fallos)) <div class="Check_01_PDF">X</div>
                    @endif

                    @if(in_array('02', $inspeccion))
                        <div class="Check_02_PDF font-dejavu">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('02', $fallos)) <div class="Check_02_PDF">X</div>
                    @endif

                    @if(in_array('03', $inspeccion))
                        <div class="Check_03_PDF font-dejavu">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('03', $fallos)) <div class="Check_03_PDF">X</div>
                    @endif

                    @if(in_array('04', $inspeccion))
                        <div class="Check_04_PDF font-dejavu">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('04', $fallos)) <div class="Check_04_PDF">X</div>
                    @endif

                    @if(in_array('05', $inspeccion))
                        <div class="Check_05_PDF font-dejavu">&#10003;</div>
                    @elseif(isset($fallos) && is_array($fallos) && in_array('05', $fallos)) <div class="Check_05_PDF">X</div>
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
                    @if(in_array('05', $fallos))
                    <div class="Check_05_PDF">X</div> @endif
                @endif
            @else
                <div class="checkboxes">
                    <div class="item-chequeo">
                        <span class="check-item-web">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="01" id="check01">
                        <label for="check01" class="check-label-web"></label>

                        <span class="check-item-web">X</span>
                        <input type="checkbox" name="fallos[]" value="01" id="fail01">
                        <label for="fail01"></label>
                    </div>

                    <div class="item-chequeo">
                        <span class="check-item-web">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="02" id="check02">
                        <label for="check02" class="check-label-web"></label>

                        <span class="check-item-web">X</span>
                        <input type="checkbox" name="fallos[]" value="02" id="fail02">
                        <label for="fail02"></label>
                    </div>

                    <div class="item-chequeo">
                        <span class="check-item-web">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="03" id="check03">
                        <label for="check03" class="check-label-web"></label>

                        <span class="check-item-web">X</span>
                        <input type="checkbox" name="fallos[]" value="03" id="fail03">
                        <label for="fail03"></label>
                    </div>

                    <div class="item-chequeo">
                        <span class="check-item-web">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="04" id="check04">
                        <label for="check04" class="check-label-web"></label>

                        <span class="check-item-web">X</span>
                        <input type="checkbox" name="fallos[]" value="04" id="fail04">
                        <label for="fail04"></label>
                    </div>

                    <div class="item-chequeo_5">
                        <span class="check-item-web">✓</span>
                        <input type="checkbox" name="inspeccion[]" value="05" id="check05">
                        <label for="check05" class="check-label-web"></label>

                        <span class="check-item-web">X</span>
                        <input type="checkbox" name="fallos[]" value="05" id="fail05">
                        <label for="fail05"></label>
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


            {{-- Campo: Radio Check (Ultimo campo) --}}
            @if($modo === 'pdf')
                <div class="radio-section">
                    @if(isset($radio_check) && $radio_check == 'yes')
                        <div class="radio_check_yes_PDF font-dejavu">&#10003;</div>
                    @elseif(isset($radio_check) && $radio_check == 'no')
                        <div class="radio_check_no_PDF font-dejavu">&#10003;</div>
                    @elseif(isset($radio_check) && $radio_check == 'na')
                        <div class="radio_check_na_PDF font-dejavu">&#10003;</div>
                    @endif
                </div>
            @else
                <div class="radio-group-web">
                    <input type="radio" name="radio_check" value="yes" {{ old('radio_check') == 'yes' ? 'checked' : '' }}>

                    <input type="radio" name="radio_check" value="no" {{ old('radio_check') == 'no' ? 'checked' : '' }}>

                    <input type="radio" name="radio_check" value="na" {{ old('radio_check') == 'na' ? 'checked' : '' }}>
                </div>
            @endif

        </div>

        @if($modo !== 'pdf')
                <button type="submit" class="Descargar">Generate and Download PDF</button>
                <button type="button" id="btn_consultar" data-url="{{ route('datos.buscar') }}" data-token="{{ csrf_token() }}"
                    class="btn-consultar">
                    Consult Data
                </button>
            </form>
        @endif

</body>

</html>