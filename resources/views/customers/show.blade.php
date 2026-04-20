@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Cliente: {{ $customer->nombre }}</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-gray-500">Documento</p><p class="font-medium">{{ $customer->documento_tipo == '1' ? 'DNI' : 'RUC' }}: {{ $customer->documento_numero }}</p></div>
            <div><p class="text-gray-500">Email</p><p class="font-medium">{{ $customer->email }}</p></div>
            <div><p class="text-gray-500">Teléfono</p><p class="font-medium">{{ $customer->telefono }}</p></div>
            <div><p class="text-gray-500">Dirección</p><p class="font-medium">{{ $customer->direccion }}</p></div>
            <div><p class="text-gray-500">Estado</p><p class="font-medium">{{ $customer->estado }}</p></div>
        </div>
    </div>

    <div class="mt-6 flex">
        <a href="{{ route('customers.edit', $customer) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-4">Editar</a>
        <a href="{{ route('customers.index') }}" class="text-gray-600 hover:text-gray-900">Volver</a>
    </div>
</div>
@endsection