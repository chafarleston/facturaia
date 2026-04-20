@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Editar Empresa</h1>

    <form method="POST" action="{{ route('companies.update', $company) }}">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">RUC</label>
                <input type="text" name="ruc" value="{{ $company->ruc }}" class="w-full rounded border-gray-300 border px-3 py-2" required maxlength="11">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Contribuyente</label>
                <select name="tipo_contribuyente" class="w-full rounded border-gray-300 border px-3 py-2">
                    <option value="RIESGO" {{ $company->tipo_contribuyente == 'RIESGO' ? 'selected' : '' }}>Riesgo</option>
                    <option value="MYPES" {{ $company->tipo_contribuyente == 'MYPES' ? 'selected' : '' }}>MYPES</option>
                    <option value="OTROS" {{ $company->tipo_contribuyente == 'OTROS' ? 'selected' : '' }}>Otros</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Razón Social</label>
                <input type="text" name="razon_social" value="{{ $company->razon_social }}" class="w-full rounded border-gray-300 border px-3 py-2" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Comercial</label>
                <input type="text" name="nombre_comercial" value="{{ $company->nombre_comercial }}" class="w-full rounded border-gray-300 border px-3 py-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                <input type="text" name="direccion" value="{{ $company->direccion }}" class="w-full rounded border-gray-300 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ $company->telefono }}" class="w-full rounded border-gray-300 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $company->email }}" class="w-full rounded border-gray-300 border px-3 py-2">
            </div>
            
            <div class="md:col-span-2 border-t pt-4 mt-4">
                <h3 class="text-lg font-bold mb-4">Configuración SUNAT</h3>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Envío</label>
                <select name="soap_type_id" class="w-full rounded border-gray-300 border px-3 py-2">
                    <option value="01" {{ $company->soap_type_id == '01' ? 'selected' : '' }}>Beta (Pruebas)</option>
                    <option value="02" {{ $company->soap_type_id == '02' ? 'selected' : '' }}>Producción</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Usuario SOL</label>
                <input type="text" name="soap_username" value="{{ $company->soap_username }}" class="w-full rounded border-gray-300 border px-3 py-2" placeholder="Usuario del SOL">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Clave SOL</label>
                <input type="password" name="soap_password" value="{{ $company->soap_password }}" class="w-full rounded border-gray-300 border px-3 py-2" placeholder="Clave del SOL">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('companies.show', $company) }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
        </div>
    </form>
</div>
@endsection