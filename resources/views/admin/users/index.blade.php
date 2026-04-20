@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Usuarios</h2>
    <a href="{{ route('users.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Nuevo Usuario</a>
  </div>
  <table class="min-w-full bg-white rounded shadow">
    <thead>
      <tr>
        <th class="px-4 py-2 text-left">Nombre</th>
        <th class="px-4 py-2 text-left">Email</th>
        <th class="px-4 py-2 text-left">Rol</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $u)
      <tr class="border-t">
        <td class="px-4 py-2">{{ $u->name }}</td>
        <td class="px-4 py-2">{{ $u->email }}</td>
        <td class="px-4 py-2">{{ $u->role }}</td>
        <td class="px-4 py-2">
          <a href="{{ route('users.edit', $u) }}" class="text-blue-600">Editar</a>
          <form action="{{ route('users.destroy', $u) }}" method="POST" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="ml-3 text-red-600" onclick="return confirm('Eliminar usuario?')">Eliminar</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
