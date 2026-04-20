@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Editar Cliente</h1>

    <form method="POST" action="{{ route('customers.update', $customer) }}">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Documento</label>
                <select name="documento_tipo" class="w-full rounded border-gray-300 border px-3 py-2" required>
                    <option value="1" {{ $customer->documento_tipo == '1' ? 'selected' : '' }}>DNI</option>
                    <option value="6" {{ $customer->documento_tipo == '6' ? 'selected' : '' }}>RUC</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Número Documento</label>
                <input type="text" name="documento_numero" value="{{ $customer->documento_numero }}" class="w-full rounded border-gray-300 border px-3 py-2" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre / Razón Social</label>
                <input type="text" name="nombre" value="{{ $customer->nombre }}" class="w-full rounded border-gray-300 border px-3 py-2" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                <input type="text" name="direccion" value="{{ $customer->direccion }}" class="w-full rounded border-gray-300 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ $customer->telefono }}" class="w-full rounded border-gray-300 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $customer->email }}" class="w-full rounded border-gray-300 border px-3 py-2">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('customers.show', $customer) }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
        </div>
    </form>
</div>
@endsection