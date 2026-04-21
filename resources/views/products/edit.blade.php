@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Editar Producto</h1>

    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código Interno</label>
                <input type="text" name="codigo" value="{{ $product->codigo }}" class="w-full rounded border-gray-300 border px-3 py-2 bg-gray-100" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código SUNAT (Catálogo UBL 2.1)</label>
                <select name="codigo_sunat" class="w-full rounded border-gray-300 border px-3 py-2">
                    <option value="">Seleccionar...</option>
                    @foreach(\App\Models\SunatProduct::orderBy('descripcion')->get() as $sunat)
                        <option value="{{ $sunat->codigo }}" {{ $product->codigo_sunat == $sunat->codigo ? 'selected' : '' }}>{{ $sunat->codigo }} - {{ $sunat->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <input type="text" name="descripcion" value="{{ $product->descripcion }}" class="w-full rounded border-gray-300 border px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Unitario (Con IGV)</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">S/</span>
                    <input type="number" id="precio_con_igv" name="precio_con_igv" value="{{ $product->precio }}" class="w-full rounded border-gray-300 border px-3 py-2 pl-8" step="0.01" min="0">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Unitario (Sin IGV)</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">S/</span>
                    <input type="number" id="precio_sin_igv" name="precio_sin_igv" value="{{ number_format($product->precio / 1.18, 2) }}" class="w-full rounded border-gray-300 border px-3 py-2 pl-8" step="0.01" min="0">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Afectación IGV</label>
                <select name="tipo_afectacion" class="w-full rounded border-gray-300 border px-3 py-2" required>
                    <option value="GRA" {{ $product->tipo_afectacion == 'GRA' ? 'selected' : '' }}>Gravado - 18%</option>
                    <option value="EXO" {{ $product->tipo_afectacion == 'EXO' ? 'selected' : '' }}>Exonerado - 0%</option>
                    <option value="INA" {{ $product->tipo_afectacion == 'INA' ? 'selected' : '' }}>Inafecto - 0%</option>
                    <option value="EXE" {{ $product->tipo_afectacion == 'EXE' ? 'selected' : '' }}>Exportación - 0%</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unidad de Medida</label>
                <select name="umedida_codigo" class="w-full rounded border-gray-300 border px-3 py-2">
                    <option value="NIU" {{ $product->umedida_codigo == 'NIU' ? 'selected' : '' }}>Unidad (NIU)</option>
                    <option value="KGM" {{ $product->umedida_codigo == 'KGM' ? 'selected' : '' }}>Kilogramo (KGM)</option>
                    <option value="GRM" {{ $product->umedida_codigo == 'GRM' ? 'selected' : '' }}>Gramo (GRM)</option>
                    <option value="LTR" {{ $product->umedida_codigo == 'LTR' ? 'selected' : '' }}>Litro (LTR)</option>
                    <option value="MLT" {{ $product->umedida_codigo == 'MLT' ? 'selected' : '' }}>Mililitro (MLT)</option>
                    <option value="MTK" {{ $product->umedida_codigo == 'MTK' ? 'selected' : '' }}>Metro cuadrado (MTK)</option>
                    <option value="MTQ" {{ $product->umedida_codigo == 'MTQ' ? 'selected' : '' }}>Metro cúbico (MTQ)</option>
                    <option value="HR" {{ $product->umedida_codigo == 'HR' ? 'selected' : '' }}>Hora (HR)</option>
                    <option value="D" {{ $product->umedida_codigo == 'D' ? 'selected' : '' }}>Día (D)</option>
                    <option value="TNE" {{ $product->umedida_codigo == 'TNE' ? 'selected' : '' }}>Tonelada (TNE)</option>
                    <option value="BX" {{ $product->umedida_codigo == 'BX' ? 'selected' : '' }}>Caja (BX)</option>
                    <option value="PK" {{ $product->umedida_codigo == 'PK' ? 'selected' : '' }}>Paquete (PK)</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('products.show', $product) }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
        </div>
    </form>
</div>

<script>
const IGV_RATE = 1.18;

const precioSinIgvInput = document.getElementById('precio_sin_igv');
const precioConIgvInput = document.getElementById('precio_con_igv');

// Con IGV is the main field (what user sees and pays)
// Sin IGV is calculated from Con IGV for display purposes only
precioSinIgvInput.addEventListener('input', function() {
    const sinIgv = parseFloat(this.value) || 0;
    if (precioConIgvInput && precioConIgvInput.value !== '') {
        precioConIgvInput.value = (sinIgv * IGV_RATE).toFixed(2);
    }
});

// When user changes Con IGV, do not overwrite Sin IGV to preserve user edits
precioConIgvInput.addEventListener('input', function() {
    // The backend will compute and save the correct pairing
});
</script>
@endsection
