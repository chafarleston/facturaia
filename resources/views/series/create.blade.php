@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Nueva Serie</h1>

    <form method="POST" action="{{ route('series.store') }}">
        @csrf
        <input type="hidden" name="company_id" value="{{ $company->id }}">

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
            <select name="tipo_documento" class="w-full border rounded px-3 py-2" required>
                <option value="01">Factura</option>
                <option value="03">Boleta</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Número de Serie</label>
            <input type="text" name="serie" class="w-full border rounded px-3 py-2" placeholder="Ej: F001, B001" maxlength="4" required>
            <p class="text-sm text-gray-500 mt-1">Ingrese hasta 4 caracteres (ej: F001, B001)</p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Crear Serie</button>
            <a href="{{ route('series.index') }}" class="text-gray-600 hover:text-gray-900 py-2">Cancelar</a>
        </div>
    </form>
</div>
@endsection