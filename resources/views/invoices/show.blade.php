@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
<h1 class="text-2xl font-bold mb-6">{{ $invoice->document_type_name }} {{ $invoice->full_number }}
  @if($invoice->tipo_documento == 'NV')
    <span class="ml-2 inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Nota de Venta</span>
  @endif
  </h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div><p class="text-gray-500 text-sm">Fecha</p><p class="font-medium">{{ $invoice->fecha_emision }}</p></div>
            <div><p class="text-gray-500 text-sm">Cliente</p><p class="font-medium">{{ $invoice->customer->nombre }}</p></div>
            <div><p class="text-gray-500 text-sm">Documento</p><p class="font-medium">{{ $invoice->customer->documento_tipo == '1' ? 'DNI' : 'RUC' }}: {{ $invoice->customer->documento_numero }}</p></div>
            <div>
                <p class="text-gray-500 text-sm">Estado SUNAT</p>
                <p class="font-medium @if($invoice->sunat_estado == 'ACEPTADO' || $invoice->sunat_estado == 'ENVIADO') text-green-600 @elseif($invoice->sunat_estado == 'ERROR' || $invoice->sunat_estado == 'RECHAZADO') text-red-600 @endif">
                    {{ $invoice->sunat_estado }}
                    @if($invoice->sunat_code)({{ $invoice->sunat_code }})@endif
                </p>
            </div>
        </div>
    @if($invoice->sunat_description)
    <div class="mt-4 p-3 bg-gray-50 rounded">
        <p class="text-sm text-gray-600">{{ $invoice->sunat_description }}</p>
    </div>
    @endif
    @if($invoice->isNotaVenta())
    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
        <p class="text-sm text-yellow-700">Nota de Venta - NV no envía a SUNAT. Este documento es para ventas internas.</p>
    </div>
    @endif
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Código</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Descripción</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Cantidad</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Precio</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($invoice->items as $item)
                <tr>
                    <td class="px-4 py-2">{{ $item->codigo }}</td>
                    <td class="px-4 py-2">{{ $item->descripcion }}</td>
                    <td class="px-4 py-2 text-right">{{ $item->cantidad }}</td>
                    <td class="px-4 py-2 text-right">S/ {{ number_format($item->precio_unitario, 2) }}</td>
                    <td class="px-4 py-2 text-right">S/ {{ number_format($item->precio_venta, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        <div class="text-right">
            <p class="text-gray-600">Subtotal: <span>S/ {{ number_format($invoice->gravado, 2) }}</span></p>
            <p class="text-gray-600">IGV: <span>S/ {{ number_format($invoice->igv, 2) }}</span></p>
            <p class="text-xl font-bold">Total: <span>S/ {{ number_format($invoice->total, 2) }}</span></p>
        </div>
    </div>
    
    @if($invoice->creditNote)
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <h3 class="font-bold text-yellow-800 mb-2">Nota de Crédito Generada</h3>
        <p><strong>Documento:</strong> {{ $invoice->creditNote->full_number }}</p>
        <p><strong>Estado SUNAT:</strong> <span class="@if($invoice->creditNote->sunat_estado == 'ACEPTADO') text-green-600 @else text-red-600 @endif">{{ $invoice->creditNote->sunat_estado }}</span></p>
        <a href="{{ route('invoices.show', $invoice->creditNote) }}" class="inline-block mt-2 text-yellow-700 hover:text-yellow-900 underline">Ver Nota de Crédito</a>
    </div>
    @endif
    
    @if($invoice->tipo_documento == '07' && $invoice->originalInvoice)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h3 class="font-bold text-blue-800 mb-2">Documento Modificado</h3>
        <p><strong>Factura/Boleta original:</strong> {{ $invoice->originalInvoice->full_number }}</p>
        <a href="{{ route('invoices.show', $invoice->originalInvoice) }}" class="inline-block mt-2 text-blue-700 hover:text-blue-900 underline">Ver Documento Original</a>
    </div>
    @endif

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Ver PDF</a>
        <a href="{{ route('invoices.ticket', $invoice) }}" target="_blank" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">Ticket (80mm)</a>
        
        @if($invoice->xml_firmado)
        <a href="{{ route('invoices.downloadXml', $invoice) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Descargar XML</a>
        @endif
        
        @if($invoice->cdr_path || $invoice->sunat_estado == 'ACEPTADO')
        <a href="{{ route('invoices.downloadCdr', $invoice) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">Descargar CDR</a>
        @endif
        
        @if($invoice->sunat_estado == 'ACEPTADO' && !$invoice->credit_note_id && $invoice->tipo_documento != '07')
        <a href="{{ route('invoices.creditNoteForm', $invoice) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">Nota de Crédito</a>
        @endif
        
        @if($invoice->sunat_estado != 'ACEPTADO' && $invoice->sunat_estado != 'ENVIADO')
        <a href="{{ route('invoices.send', $invoice) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Enviar a SUNAT</a>
        @endif
        
        @if($invoice->sunat_estado == 'ACEPTADO' && $invoice->tipo_documento != '07')
        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de dar de baja este documento en SUNAT? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Dar de Baja SUNAT</button>
        </form>
        @endif
        
        <a href="{{ route('invoices.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Volver</a>
    </div>
</div>
@endsection
