@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        @if($tipoDocumento == '01')
            <h1 class="text-2xl font-bold">Facturas</h1>
        @elseif($tipoDocumento == '03')
            <h1 class="text-2xl font-bold">Boletas</h1>
        @elseif($tipoDocumento == '07')
            <h1 class="text-2xl font-bold">Notas de Crédito</h1>
        @else
            <h1 class="text-2xl font-bold">Todos los Comprobantes</h1>
        @endif
        <a href="{{ route('invoices.create', ['company_id' => $companyId]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Generar Comprobante</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado SUNAT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($invoices as $invoice)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->document_type_name }} {{ $invoice->full_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->customer->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->fecha_emision }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">S/ {{ number_format($invoice->total, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($invoice->sunat_estado)
                            @case('PENDIENTE') <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span> @break
                            @case('ENVIADO') <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Enviado</span> @break
                            @case('ACEPTADO') <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aceptado</span> @break
                            @case('RECHAZADO') <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazado</span> @break
                            @case('ANULADO') <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Anulado</span> @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                        @if($invoice->xml_path)
                            <a href="{{ route('invoices.downloadXml', $invoice) }}" class="text-gray-600 hover:text-gray-900">XML</a>
                        @endif
                        @if($invoice->tipo_documento == 'NV')
                            <a href="{{ route('invoices.print_nv_a4', $invoice) }}" class="ml-2 text-green-600">Imprimir NV A4</a>
                            <a href="{{ route('invoices.print_nv_ticket', $invoice) }}" class="ml-2 text-green-600">Imprimir NV Ticket</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay documentos</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $invoices->links() }}</div>
    </div>
</div>
@endsection
