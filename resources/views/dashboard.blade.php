@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Facturas -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Comprobantes</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $stats['total'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            
            <!-- Facturas Enviadas -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Aceptados SUNAT</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $stats['aceptados'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            
            <!-- Pendientes -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pendientes</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $stats['pendientes'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            
            <!-- Total Ventas -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0V7m-3 1h4m-4 0H7" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Ventas</dt>
                            <dd class="text-lg font-semibold text-gray-900">S/ {{ number_format($stats['total_ventas'], 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Ventas por Día -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ventas Últimos 7 días</h3>
                @php
                    $maxMonto = collect($ventasPorDia)->max('monto') ?: 1;
                    $maxPorcentaje = collect($ventasPorDia)->max(function($d) use ($maxMonto) {
                        return $maxMonto > 0 ? ($d['monto'] / $maxMonto) * 100 : 0;
                    }) ?: 1;
                @endphp
                <div class="flex items-end space-x-2 h-48">
                    @foreach($ventasPorDia as $dia)
                        @php
                            $height = $maxMonto > 0 ? ($dia['monto'] / $maxMonto) * 100 : 0;
                            if ($height == 0) $height = 2;
                        @endphp
                        <div class="flex-1 flex flex-col items-center justify-end">
                            <div class="w-full bg-blue-500 rounded-t" style="height: {{ $height }}%"></div>
                        </div>
                    @endforeach
                </div>
                <div class="flex space-x-1 mt-2">
                    @foreach($ventasPorDia as $dia)
                        <div class="flex-1 text-center text-xs text-gray-500">{{ $dia['dia'] }}</div>
                    @endforeach
                </div>
            </div>
            
            <!-- Documentos por Tipo -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Documentos por Tipo</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-600">Facturas</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $stats['facturas'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-600">Boletas</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $stats['boletas'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                            <span class="text-sm text-gray-600">Notas de Crédito</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $stats['notas_credito'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Documents -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-6 py-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Documentos Recientes</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentInvoices as $invoice)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $invoice->document_type_name }} {{ $invoice->full_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->customer->nombre ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->fecha_emision }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">S/ {{ number_format($invoice->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($invoice->sunat_estado)
                                @case('ACEPTADO')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aceptado</span>
                                    @break
                                @case('PENDIENTE')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                    @break
                                @case('ENVIADO')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Enviado</span>
                                    @break
                                @case('RECHAZADO')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazado</span>
                                    @break
                                @default
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $invoice->sunat_estado ?? 'Sin estado' }}</span>
                            @endswitch
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay documentos</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection