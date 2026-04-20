@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Empresas</h1>
        <a href="{{ route('companies.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Nueva Empresa</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">RUC</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Razón Social</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($companies as $company)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->ruc }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->razon_social }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $company->is_main ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">{{ $company->is_main ? 'PRINCIPAL' : $company->estado }}</span></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('companies.show', $company) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                        <a href="{{ route('companies.edit', $company) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                        @if(!$company->is_main)
                        <form action="{{ route('companies.setMain', $company) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-blue-600 hover:text-blue-900" onclick="return confirm('¿Establecer como empresa principal?')">Principal</button>
                        </form>
                        @endif
                        <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline ml-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar empresa?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay empresas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection