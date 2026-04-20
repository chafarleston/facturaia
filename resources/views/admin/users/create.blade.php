@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-8">
  <h2 class="text-xl font-semibold mb-4">Crear Usuario</h2>
  <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm">Nombre</label>
      <input name="name" class="w-full border rounded p-2" />
    </div>
    <div>
      <label class="block text-sm">Email</label>
      <input type="email" name="email" class="w-full border rounded p-2" />
    </div>
    <div>
      <label class="block text-sm">Contraseña</label>
      <input type="password" name="password" class="w-full border rounded p-2" />
    </div>
    <div>
      <label class="block text-sm">Confirmar Contraseña</label>
      <input type="password" name="password_confirmation" class="w-full border rounded p-2" />
    </div>
    <div>
      <label class="block text-sm">Rol</label>
      <select name="role" class="w-full border rounded p-2">
        <option value="user">Usuario</option>
        <option value="admin">Administrador</option>
      </select>
    </div>
    <div>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Crear</button>
    </div>
  </form>
  
</div>
@endsection
