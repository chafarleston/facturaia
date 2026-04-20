@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-8">
  <h2 class="text-xl font-semibold mb-4">Editar Usuario</h2>
  <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
      <label class="block text-sm">Nombre</label>
      <input name="name" value="{{ $user->name }}" class="w-full border rounded p-2" />
    </div>
    <div>
      <label class="block text-sm">Email</label>
      <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2" />
    </div>
    <div>
      <label class="block text-sm">Rol</label>
      <select name="role" class="w-full border rounded p-2">
        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
      </select>
    </div>
    <div>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
    </div>
  </form>
</div>
@endsection
