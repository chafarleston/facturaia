@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Nuevo Producto</h1>

    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <input type="hidden" name="company_id" value="{{ $companyId }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código Interno</label>
                <input type="text" name="codigo" value="{{ $codigo }}" class="w-full rounded border-gray-300 border px-3 py-2 bg-gray-100" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código SUNAT (Catálogo UBL 2.1)</label>
                <select name="codigo_sunat" class="w-full rounded border-gray-300 border px-3 py-2">
                    <option value="">Seleccionar...</option>
                    @foreach(\App\Models\SunatProduct::orderBy('descripcion')->get() as $sunat)
                        <option value="{{ $sunat->codigo }}">{{ $sunat->codigo }} - {{ $sunat->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <input type="text" name="descripcion" class="w-full rounded border-gray-300 border px-3 py-2" required placeholder="Nombre del producto">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Unitario (Sin IGV)</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">S/</span>
                    <input type="number" id="precio_sin_igv" name="precio_sin_igv" class="w-full rounded border-gray-300 border px-3 py-2 pl-8" required step="0.01" min="0" placeholder="0.00">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Precio Unitario (Con IGV)</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">S/</span>
                    <input type="number" id="precio_con_igv" name="precio_con_igv" class="w-full rounded border-gray-300 border px-3 py-2 pl-8" step="0.01" min="0" placeholder="0.00">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Afectación IGV</label>
                <select name="tipo_afectacion" class="w-full rounded border-gray-300 border px-3 py-2" required>
                    <option value="GRA">Gravado - 18%</option>
                    <option value="EXO">Exonerado - 0%</option>
                    <option value="INA">Inafecto - 0%</option>
                    <option value="EXE">Exportación - 0%</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unidad de Medida</label>
                <select name="umedida_codigo" class="w-full rounded border-gray-300 border px-3 py-2">
                    <option value="NIU">Unidad (NIU)</option>
                    <option value="KGM">Kilogramo (KGM)</option>
                    <option value="GRM">Gramo (GRM)</option>
                    <option value="LTR">Litro (LTR)</option>
                    <option value="MLT">Mililitro (MLT)</option>
                    <option value="MTK">Metro cuadrado (MTK)</option>
                    <option value="MTQ">Metro cúbico (MTQ)</option>
                    <option value="HR">Hora (HR)</option>
                    <option value="D">Día (D)</option>
                    <option value="TNE">Tonelada (TNE)</option>
                    <option value="BX">Caja (BX)</option>
                    <option value="PK">Paquete (PK)</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('products.index', ['company_id' => $companyId]) }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
        </div>
    </form>
</div>

<script>
const IGV_RATE = 1.18;

const precioSinIgvInput = document.getElementById('precio_sin_igv');
const precioConIgvInput = document.getElementById('precio_con_igv');
let syncing = false;

// Two-way synchronization with guard to avoid loops
precioSinIgvInput.addEventListener('input', function() {
  if (syncing) return;
  const sinIgv = parseFloat(this.value) || 0;
  if (precioConIgvInput) {
    syncing = true;
    precioConIgvInput.value = (sinIgv * IGV_RATE).toFixed(2);
    syncing = false;
  }
});

if (precioConIgvInput) {
  precioConIgvInput.addEventListener('input', function() {
    if (syncing) return;
    const conIgv = parseFloat(this.value) || 0;
    syncing = true;
    precioSinIgvInput.value = (conIgv / IGV_RATE).toFixed(2);
    syncing = false;
  });
}
</script>
@endsection
