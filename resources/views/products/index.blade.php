@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Productos</h1>
        <a href="{{ route('products.create', ['company_id' => $companyId]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Nuevo Producto</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo Afect.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->codigo }}</td>
                    <td class="px-6 py-4">{{ $product->descripcion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">S/ {{ number_format($product->precio, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->tipo_afectacion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                        <a href="{{ route('products.edit', $product) }}" class="text-yellow-600 hover:text-yellow-900">Editar</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay productos</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $products->links() }}</div>
    </div>
</div>
@endsection