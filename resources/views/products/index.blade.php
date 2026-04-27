@extends('layouts.admin')
@section('title', 'Productos')
@section('page_title', 'Productos')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Lista de Productos</h3>
        <div class="card-tools">
          <a href="{{ route('products.create', ['company_id' => $companyId ?? null]) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nuevo Producto
          </a>
        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>Código</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Tipo Afect.</th>
              <th>Stock</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
            <tr>
              <td>{{ $product->codigo }}</td>
              <td>{{ $product->descripcion }}</td>
              <td>S/ {{ number_format($product->precio, 2) }}</td>
              <td>{{ $product->tipo_afectacion }}</td>
              <td>{{ $product->stock }}</td>
              <td>
                <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No hay productos</td></tr>
            @endforelse
          </tbody>
        </table>
        <div class="card-footer">{{ $products->links() }}</div>
      </div>
    </div>
  </div>
</div>
@endsection