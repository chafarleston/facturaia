@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Empresa: {{ $company->razon_social }}</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-gray-500">RUC</p><p class="font-medium">{{ $company->ruc }}</p></div>
            <div><p class="text-gray-500">Tipo</p><p class="font-medium">{{ $company->tipo_contribuyente }}</p></div>
            <div><p class="text-gray-500">Nombre Comercial</p><p class="font-medium">{{ $company->nombre_comercial }}</p></div>
            <div><p class="text-gray-500">Dirección</p><p class="font-medium">{{ $company->direccion }}</p></div>
            <div><p class="text-gray-500">Teléfono</p><p class="font-medium">{{ $company->telefono }}</p></div>
            <div><p class="text-gray-500">Email</p><p class="font-medium">{{ $company->email }}</p></div>
            <div><p class="text-gray-500">Estado</p><p class="font-medium">{{ $company->estado }}</p></div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-bold mb-4">Certificado Digital SUNAT</h2>
        
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        @if($company->certificado_path)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p>✅ Certificado cargado: {{ $company->certificado_path }}</p>
            @if($company->certificado_vence)
            <p class="text-sm">Vence: {{ $company->certificado_vence }}</p>
            @endif
        </div>
        @endif

        <form method="POST" action="{{ route('companies.certificate', $company) }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Archivo Certificate (.pfx)</label>
                    <input type="file" name="certificado" accept=".p12,.pfx" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña del Certificate</label>
                    <input type="password" name="certificado_password" class="w-full border rounded px-3 py-2" placeholder="Contraseña">
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Subir Certificate</button>
        </form>
    </div>

    <div class="mt-6 flex">
        <a href="{{ route('companies.edit', $company) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-4">Editar</a>
        <a href="{{ route('companies.index') }}" class="text-gray-600 hover:text-gray-900">Volver</a>
    </div>
</div>
@endsection