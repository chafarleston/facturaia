@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">Nota de Crédito</h1>
    
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Documento a modificar</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Tipo:</p>
                <p class="font-medium">{{ $invoice->tipo_documento == '01' ? 'FACTURA' : 'BOLETA' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Número:</p>
                <p class="font-medium">{{ $invoice->full_number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Fecha:</p>
                <p class="font-medium">{{ $invoice->fecha_emision }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total:</p>
                <p class="font-medium">S/ {{ number_format($invoice->total, 2) }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-sm text-gray-600">Cliente:</p>
                <p class="font-medium">{{ $invoice->customer->nombre }}</p>
                <p class="text-sm">{{ $invoice->customer->documento_tipo == '6' ? 'RUC: ' : 'DNI: ' }}{{ $invoice->customer->documento_numero }}</p>
            </div>
        </div>
    </div>
    
    <form action="{{ route('invoices.sendCreditNote', $invoice) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        
        <h2 class="text-lg font-semibold mb-4">Datos de la Nota de Crédito</h2>
        
        <div class="mb-4">
            <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo de la nota</label>
            <select name="motivo" id="motivo" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione un motivo</option>
                <option value="01">01 - Anulación de la operación</option>
                <option value="02">02 - Anulación por error en el RUC</option>
                <option value="03">03 - Corrección por error en la descripción</option>
                <option value="04">04 - Descuento global</option>
                <option value="05">05 - Descuento por ítem</option>
                <option value="06">06 - Devolución por ítem</option>
                <option value="07">07 - Devolución total</option>
                <option value="08">08 - Bonificación</option>
                <option value="09">09 - Disminución en el valor</option>
                <option value="10">10 - Otros conceptos</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción del motivo</label>
            <input type="text" name="descripcion" id="descripcion" required 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ej: ANULACIÓN DE FACTURA">
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Monto a acreditar</label>
            <p class="text-lg font-bold text-green-600">S/ {{ number_format($invoice->total, 2) }}</p>
            <p class="text-sm text-gray-500">Se generará nota de crédito por el total del documento</p>
        </div>
        
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Generar Nota de Crédito
            </button>
            <a href="{{ route('invoices.show', $invoice) }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection