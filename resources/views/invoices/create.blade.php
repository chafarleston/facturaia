@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6">Nueva Factura/Boleta</h1>

    <form id="invoice-form" method="POST" action="{{ route('invoices.store') }}">
        @csrf
        <input type="hidden" name="company_id" value="{{ $company->id }}">
        <input type="hidden" name="customer_id" id="customer_id">
        <input type="hidden" name="customer_data[documento_tipo]" id="customer_data_documento_tipo">
        <input type="hidden" name="customer_data[documento_numero]" id="customer_data_documento_numero">
        <input type="hidden" name="customer_data[nombre]" id="customer_data_nombre">
        <input type="hidden" name="customer_data[direccion]" id="customer_data_direccion">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Documento</label>
                <select name="tipo_documento" id="tipo_documento" class="w-full border rounded px-3 py-2" required onchange="updateSerie()">
                    <option value="01">Factura</option>
                    <option value="03">Boleta</option>
                    <option value="NV">Nota de Venta</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Serie</label>
                @if($series->isEmpty())
                    <div class="text-red-500 text-sm">No hay series disponibles. <a href="{{ route('series.create', ['company_id' => $company->id]) }}" class="underline">Crear serie</a></div>
                    <select name="serie_id" id="serie_id" class="w-full border rounded px-3 py-2 bg-gray-100" disabled>
                        <option value="">Sin series</option>
                    </select>
                @else
                    <select name="serie_id" id="serie_id" class="w-full border rounded px-3 py-2 bg-gray-100" required onchange="updateTipoDocumento()">
                        @foreach($series as $serie)
                            <option value="{{ $serie->id }}" data-tipo="{{ $serie->tipo_documento }}" data-serie="{{ $serie->serie }}">{{ $serie->serie }} ({{ $serie->tipo_documento == '01' ? 'Factura' : 'Boleta' }})</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <input type="date" name="fecha_emision" class="w-full border rounded px-3 py-2" required value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <script>
        function updateSerie() {
            const tipoDoc = document.getElementById('tipo_documento').value;
            const serieSelect = document.getElementById('serie_id');
            if (!serieSelect) return;
            const options = Array.from(serieSelect.options);
            // Prefer FC01 for Factura (01) and BC01 for Boleta (03)
            const preferredCode = tipoDoc === '01' ? 'FC01' : (tipoDoc === '03' ? 'BC01' : (tipoDoc === 'NV' ? 'NV01' : null));
            // Try to select by preferred code first
            if (preferredCode) {
                for (let idx = 0; idx < options.length; idx++) {
                    const opt = options[idx];
                    const serieCode = opt.getAttribute('data-serie');
                    if (serieCode === preferredCode) {
                        serieSelect.selectedIndex = idx;
                        return;
                    }
                }
            }
            // Fallback: select first option that matches the document type
            for (let idx = 0; idx < options.length; idx++) {
                const opt = options[idx];
                const serieTipo = opt.getAttribute('data-tipo');
                if (serieTipo === tipoDoc) {
                    serieSelect.selectedIndex = idx;
                    return;
                }
            }
        }
        
        function updateTipoDocumento() {
            const serieSelect = document.getElementById('serie_id');
            const selectedOption = serieSelect.options[serieSelect.selectedIndex];
            const serieTipo = selectedOption.getAttribute('data-tipo');
            document.getElementById('tipo_documento').value = serieTipo;
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSerie();
        });
        </script>

        <div class="bg-gray-50 p-4 rounded mb-6">
            <h3 class="font-bold mb-4">Datos del Cliente</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select id="doc_tipo" class="w-full border rounded px-3 py-2">
                        <option value="1">DNI</option>
                        <option value="6">RUC</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                    <div class="flex">
                        <input type="text" id="doc_numero" class="w-full border rounded px-3 py-2" maxlength="11">
                        <button type="button" class="ml-2 bg-blue-600 text-white px-3 py-2 rounded" onclick="buscarCliente()">🔍</button>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" id="customer_nombre" class="w-full border rounded px-3 py-2">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input type="text" id="customer_direccion" class="w-full border rounded px-3 py-2">
                </div>
            </div>
            <div class="mt-3 flex items-center justify-between">
                <span id="customer-status" class="text-sm"></span>
                <button type="button" id="setCustomerBtn" class="bg-blue-600 text-white px-4 py-2 rounded hidden" onclick="setCustomer()">✓ Establecer Cliente</button>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded mb-6">
            <h3 class="font-bold mb-4">Agregar Producto</h3>
            @if($products->isEmpty())
                <div class="text-red-500 mb-4">No hay productos registrados. <a href="{{ route('products.create', ['company_id' => $company->id]) }}" class="underline">Crear producto</a></div>
            @else
            <div class="flex gap-4 mb-4">
                <select id="productSelect" class="flex-1 border rounded px-3 py-2">
                    <option value="">Seleccionar producto</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->precio }}" data-code="{{ $product->codigo }}" data-name="{{ $product->descripcion }}">
                            {{ $product->codigo }} - {{ $product->descripcion }} - S/ {{ number_format($product->precio, 2) }}
                        </option>
                    @endforeach
                </select>
                <input type="number" id="itemQty" class="w-24 border rounded px-3 py-2" value="1" min="0.01" step="0.01">
                <input type="number" id="itemPrice" class="w-32 border rounded px-3 py-2" step="0.01" placeholder="Precio">
                <button type="button" class="bg-green-600 text-white px-4 py-2 rounded" onclick="agregarItem()">Agregar</button>
            </div>
            @endif

            <table class="min-w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-1 text-left text-xs">Código</th>
                        <th class="px-2 py-1 text-left text-xs">Descripción</th>
                        <th class="px-2 py-1 text-right text-xs">Cantidad</th>
                        <th class="px-2 py-1 text-right text-xs">Precio</th>
                        <th class="px-2 py-1 text-right text-xs">Total</th>
                        <th class="px-2 py-1"></th>
                    </tr>
                </thead>
                <tbody id="invoice-items"></tbody>
            </table>
        </div>

        <div class="flex justify-end mb-6">
            <div class="text-right">
                <p>Subtotal: <span id="subtotal">0.00</span></p>
                <p>IGV (18%): <span id="igv">0.00</span></p>
                <p class="text-xl font-bold">Total: <span id="total">0.00</span></p>
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('invoices.index', ['company_id' => $company->id]) }}" class="mr-4 text-gray-600">Cancelar</a>
            <button type="button" class="bg-indigo-600 text-white px-6 py-2 rounded" onclick="submitInvoiceForm()">Guardar</button>
        </div>
    </form>
</div>

<script>
let items = [];
const companyId = {{ $company->id }};

function submitInvoiceForm() {
    if (items.length === 0) {
        alert('Agregue al menos un producto');
        return;
    }
    
    const form = document.getElementById('invoice-form');
    
    // Add items to form
    items.forEach((item, idx) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'items[' + idx + '][product_id]';
        input.value = item.product_id;
        form.appendChild(input);
        
        const input2 = document.createElement('input');
        input2.type = 'hidden';
        input2.name = 'items[' + idx + '][codigo]';
        input2.value = item.codigo;
        form.appendChild(input2);
        
        const input3 = document.createElement('input');
        input3.type = 'hidden';
        input3.name = 'items[' + idx + '][descripcion]';
        input3.value = item.descripcion;
        form.appendChild(input3);
        
        const input4 = document.createElement('input');
        input4.type = 'hidden';
        input4.name = 'items[' + idx + '][cantidad]';
        input4.value = item.cantidad;
        form.appendChild(input4);
        
        const input5 = document.createElement('input');
        input5.type = 'hidden';
        input5.name = 'items[' + idx + '][precio]';
        input5.value = item.precio;
        form.appendChild(input5);
    });
    
    // Ensure customer data
    if (!document.getElementById('customer_id').value) {
        document.getElementById('customer_data_documento_tipo').value = document.getElementById('doc_tipo').value;
        document.getElementById('customer_data_documento_numero').value = document.getElementById('doc_numero').value;
        document.getElementById('customer_data_nombre').value = document.getElementById('customer_nombre').value;
        document.getElementById('customer_data_direccion').value = document.getElementById('customer_direccion').value;
    }
    
    form.submit();
}

function buscarCliente() {
    const docNumero = document.getElementById('doc_numero').value.trim();
    const docTipo = document.getElementById('doc_tipo').value;
    const statusEl = document.getElementById('customer-status');
    
    if (!docNumero) {
        alert('Ingrese número de documento');
        return;
    }
    
    statusEl.textContent = 'Buscando...';
    statusEl.className = 'text-sm text-blue-600';
    
    fetch('/decolecta/search?company_id=' + companyId + '&documento=' + docNumero)
        .then(res => res.json())
        .then(data => {
            if (data.found && data.exists) {
                document.getElementById('customer_id').value = data.customer.id;
                document.getElementById('customer_nombre').value = data.customer.nombre;
                document.getElementById('customer_direccion').value = data.customer.direccion || '';
                document.getElementById('doc_tipo').value = data.customer.documento_tipo;
                document.getElementById('customer_data_documento_tipo').value = data.customer.documento_tipo;
                document.getElementById('customer_data_documento_numero').value = data.customer.documento_numero;
                document.getElementById('customer_data_nombre').value = data.customer.nombre;
                document.getElementById('customer_data_direccion').value = data.customer.direccion || '';
                statusEl.textContent = '✓ Cliente encontrado';
                statusEl.className = 'text-sm text-green-600';
            } else if (data.api_data) {
                document.getElementById('customer_nombre').value = data.api_data.nombre || '';
                document.getElementById('customer_direccion').value = data.api_data.direccion || '';
                document.getElementById('doc_tipo').value = data.api_data.documento_tipo || docTipo;
                document.getElementById('customer_data_documento_tipo').value = data.api_data.documento_tipo || docTipo;
                document.getElementById('customer_data_documento_numero').value = data.api_data.documento_numero || docNumero;
                document.getElementById('customer_data_nombre').value = data.api_data.nombre || '';
                document.getElementById('customer_data_direccion').value = data.api_data.direccion || '';
                statusEl.textContent = 'Datos cargados. Presione "Establecer Cliente"';
                statusEl.className = 'text-sm text-yellow-600';
                document.getElementById('setCustomerBtn').classList.remove('hidden');
            } else {
                statusEl.textContent = 'Cliente no encontrado';
                statusEl.className = 'text-sm text-red-600';
            }
        })
        .catch(err => {
            statusEl.textContent = 'Error al buscar';
            statusEl.className = 'text-sm text-red-600';
        });
}

function setCustomer() {
    const docNumero = document.getElementById('doc_numero').value;
    const docTipo = document.getElementById('doc_tipo').value;
    const nombre = document.getElementById('customer_nombre').value;
    const direccion = document.getElementById('customer_direccion').value;
    
    if (!docNumero || !nombre) {
        alert('Ingrese número de documento y nombre');
        return;
    }
    
    document.getElementById('customer_data_documento_tipo').value = docTipo;
    document.getElementById('customer_data_documento_numero').value = docNumero;
    document.getElementById('customer_data_nombre').value = nombre;
    document.getElementById('customer_data_direccion').value = direccion;
    
    document.getElementById('customer-status').textContent = '✓ Cliente establecido';
    document.getElementById('customer-status').className = 'text-sm text-green-600';
    document.getElementById('setCustomerBtn').classList.add('hidden');
}

document.getElementById('productSelect').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    document.getElementById('itemPrice').value = option.dataset.price || '';
});

function agregarItem() {
    const select = document.getElementById('productSelect');
    const option = select.options[select.selectedIndex];
    if (!option.value) {
        alert('Seleccione un producto');
        return;
    }
    
    const qty = parseFloat(document.getElementById('itemQty').value);
    const price = Math.round(parseFloat(document.getElementById('itemPrice').value) * 100) / 100;
    
    if (!qty || !price) {
        alert('Ingrese cantidad y precio');
        return;
    }
    
    items.push({
        product_id: option.value,
        codigo: option.dataset.code,
        descripcion: option.dataset.name,
        cantidad: qty,
        precio: price
    });
    
    console.log('Item added, total items:', items.length, items);
    
    renderItems();
    select.value = '';
    document.getElementById('itemQty').value = '1';
    document.getElementById('itemPrice').value = '';
}

function removeItem(index) {
    items.splice(index, 1);
    renderItems();
}

function renderItems() {
    const tbody = document.getElementById('invoice-items');
    tbody.innerHTML = '';
    let totalConIgv = 0;
    
    items.forEach((item, index) => {
        const row = document.createElement('tr');
        const itemTotal = Math.round(item.cantidad * item.precio * 100) / 100;
        row.innerHTML = `
            <td class="px-2 py-1 text-sm">${item.codigo}</td>
            <td class="px-2 py-1 text-sm">${item.descripcion}</td>
            <td class="px-2 py-1 text-right text-sm">${item.cantidad}</td>
            <td class="px-2 py-1 text-right text-sm">${item.precio.toFixed(2)}</td>
            <td class="px-2 py-1 text-right text-sm">${itemTotal.toFixed(2)}</td>
            <td class="px-2 py-1"><button type="button" onclick="removeItem(${index})" class="text-red-600">X</button></td>
        `;
        tbody.appendChild(row);
        totalConIgv += itemTotal;
    });
    
    // El precio ya incluye IGV, separamos y redondeamos
    const subtotal = Math.round(totalConIgv / 1.18 * 100) / 100;
    const igv = Math.round((totalConIgv - subtotal) * 100) / 100;
    const total = Math.round((subtotal + igv) * 100) / 100;
    
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('igv').textContent = igv.toFixed(2);
    document.getElementById('total').textContent = total.toFixed(2);
}
</script>
@endsection
