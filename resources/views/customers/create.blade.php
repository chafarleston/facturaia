@extends('layouts.admin')
@section('title', 'Nuevo Cliente')
@section('page_title', 'Nuevo Cliente')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Nuevo Cliente</h3>
    </div>
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <input type="hidden" name="company_id" value="{{ $companyId }}">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo Documento</label>
                        <select name="documento_tipo" class="form-control" required>
                            <option value="1">DNI</option>
                            <option value="6">RUC</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número Documento</label>
                        <input type="text" name="documento_numero" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Nombre / Razón Social</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('customers.index', ['company_id' => $companyId]) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
@endsection