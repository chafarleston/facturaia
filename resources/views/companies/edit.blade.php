@extends('layouts.admin')
@section('title', 'Editar Empresa')
@section('page_title', 'Editar Empresa')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Editar Empresa</h3>
    </div>
    <form method="POST" action="{{ route('companies.update', $company) }}">
        @csrf
        @method('PATCH')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>RUC</label>
                        <input type="text" name="ruc" value="{{ $company->ruc }}" class="form-control" required maxlength="11">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo Contribuyente</label>
                        <select name="tipo_contribuyente" class="form-control">
                            <option value="RIESGO" {{ $company->tipo_contribuyente == 'RIESGO' ? 'selected' : '' }}>Riesgo</option>
                            <option value="MYPES" {{ $company->tipo_contribuyente == 'MYPES' ? 'selected' : '' }}>MYPES</option>
                            <option value="OTROS" {{ $company->tipo_contribuyente == 'OTROS' ? 'selected' : '' }}>Otros</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Razón Social</label>
                <input type="text" name="razon_social" value="{{ $company->razon_social }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nombre Comercial</label>
                <input type="text" name="nombre_comercial" value="{{ $company->nombre_comercial }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" value="{{ $company->direccion }}" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" value="{{ $company->telefono }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $company->email }}" class="form-control">
                    </div>
                </div>
            </div>
            
            <hr>
            <h5>Configuración SUNAT</h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de Envío</label>
                        <select name="soap_type_id" class="form-control">
                            <option value="01" {{ $company->soap_type_id == '01' ? 'selected' : '' }}>Beta (Pruebas)</option>
                            <option value="02" {{ $company->soap_type_id == '02' ? 'selected' : '' }}>Producción</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Usuario SOL</label>
                        <input type="text" name="soap_username" value="{{ $company->soap_username }}" class="form-control" placeholder="Usuario del SOL">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Clave SOL</label>
                <input type="password" name="soap_password" value="{{ $company->soap_password }}" class="form-control" placeholder="Clave del SOL">
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('companies.show', $company) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
@endsection