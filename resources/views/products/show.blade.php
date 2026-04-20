@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Producto: {{ $product->descripcion }}</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div><p class="text-gray-500 text-sm">Código Interno</p><p class="font-medium">{{ $product->codigo }}</p></div>
            <div><p class="text-gray-500 text-sm">Código SUNAT</p><p class="font-medium">{{ $product->codigo_sunat ?: 'No asignado' }}</p></div>
            <div><p class="text-gray-500 text-sm">Precio</p><p class="font-medium">S/ {{ number_format($product->precio, 2) }}</p></div>
            <div><p class="text-gray-500 text-sm">Tipo Afectación</p><p class="font-medium">{{ $product->tipo_afectacion }}</p></div>
            <div><p class="text-gray-500 text-sm">Unidad de Medida</p><p class="font-medium">{{ $product->umedida_codigo }}</p></div>
            <div><p class="text-gray-500 text-sm">Estado</p><p class="font-medium">{{ $product->estado }}</p></div>
        </div>
    </div>

    <div class="mt-6 flex">
        <a href="{{ route('products.edit', $product) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-4">Editar</a>
        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Volver</a>
    </div>
</div>
@endsection