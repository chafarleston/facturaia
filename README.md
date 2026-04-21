# FacturaIA

Sistema de facturación electrónica para Perú (SUNAT) basado en Laravel 9. Emite facturas, boletas y notas de crédito, firma electrónicamente, envía a SUNAT (entorno beta) y genera PDFs en formato A4 y tickets de 80 mm. Incluye autenticación por roles y un sistema de temáticas visuales.

Desarrollado para: Perú
Framework: Laravel 9 (PHP 8.x)

---

## Características principales

- Emisión de comprobantes electrónicos:
  - Facturas (01)
  - Boletas (03)
  - Notas de crédito (07)
- Envío a SUNAT (entorno beta) mediante Greenter
- Generación de PDFs
  - Formato A4 profesional
  - Ticket 80 mm para impresora
- Baja de documentos en SUNAT
- CDRs y almacenamiento de respuestas SUNAT
- Temas/colores configurables por sesión (Tailwind)
- Gestión de usuarios con roles:
  - Administrador (acceso total)
  - Usuario (permisos limitados)
- Generación de código QR SUNAT por comprobante
- Hash de DigestValue extraído del XML firmado por SUNAT, mostrado en el PDF bajo el QR
- Seeds iniciales para bootstrapping (usuarios/admins y series)

---

## Flujo principal

1. Crear comprobante (factura/boleta/notas de crédito)
2. Sunat firma el XML y genera DigestValue (hash)
3. Generar código QR SUNAT (formato data URI para MPDF)
4. Crear PDFs:
   - PDF A4 (factura/boleta)
   - PDF 80 mm (tickets)
5. Mostrar en el PDF:
   - QR SUNAT arriba
   - Hash DigestValue justo debajo del QR
6. Envío a SUNAT y obtención de CDRs
7. Baja de documentos en SUNAT (opcional)

---

## Arquitectura técnica

- Backend
  - Laravel 9
  - Servicios:
    - SunatQrService: genera QR SUNAT y devuelve data URI (con fallback a URL pública)
    - GreenterService: integración con Greenter, emisión, firma, generación de PDFs y extracción del DigestValue desde el XML firmado
  - Modelo Invoice: campos como serie, numero, fecha_emision, igv, total y nuevo campo codigo_hash (DigestValue)
  - Roles y permisos: middleware/gates para exponer solo las áreas administrativas
- Frontend
  - Blade templates
  - Temas por sesión (Tailwind)
  - Menú: Generar Comprobante con submenús (Facturas, Boletas, Notas de Crédito)

---

## Estructura de archivos clave

- app/Http/Controllers/
  - InvoiceController.php
  - Auth/LogoutController.php
- app/Http/Requests/
- app/Models/
- app/Services/
  - GreenterService.php
  - SunatQrService.php
  - SunatService.php
  - SunatQrService.php
- resources/views/
  - layouts/navigation.blade.php
  - layouts/app.blade.php
  - invoices/
  - admin/users/
- database/
  - migrations/
  - seeders/
- routes/web.php
- tests/

---

## Requisitos

- PHP 8.x
- Composer
- Node.js (opcional, para assets)
- MPDF (o motor de PDF utilizado en el proyecto)
- Endroid/QR-Code (comando de instalación incluido en pasos de instalación)

---

## Instalación

1) Clonar el repositorio
- git clone <URL-DEL-REPO>
- cd facturaia

2) Instalar dependencias
- composer install
- npm install (opcional)

3) Configurar entorno
- cp .env.example .env
- editar .env con:
  - base de datos
  - ADMIN_EMAIL, ADMIN_PASSWORD, ADMIN_NAME (usuario administrador por defecto)
  - SUNAT_ENV (beta) y certificados según tu configuración

4) Generar clave y migraciones
- php artisan key:generate
- php artisan migrate --seed

5) Generar y exponer QR
- composer require endroid/qr-code
- php artisan storage:link

6) Verificar rutas
- php artisan route:list | grep pdf
- Asegúrate de que /invoices/{invoice}/pdf y /invoices/{invoice}/ticket estén disponibles

---

## Configuración de usuarios y datos iniciales

- Seeds iniciales proporcionan:
  - Administradores (admin, superadmin)
  - Usuarios de prueba (demo@example.com)
  - Series de documentos (FC01, BC01, FD01, BD01, R001, T001, P001, NV01, NIA1, NSA1)

---

## Flujo de verificación clave

- Genera una factura (01) o boleta (03) desde la UI.
- Descarga/visualiza el PDF A4 y el Ticket 80mm.
- Verifica:
  - QR SUNAT en la parte superior
  - Hash DigestValue obtenido del XML firmado por SUNAT: Hash: <DigestValue>
  - Información de SUNAT (ACEPTADO) y el footer
- Escanea el QR para confirmar que la cadena codificada sea:
  - ruc|serie|correlativo|igv|total|fecha_emision|tipo_doc_cliente|doc_cliente

---

## Pruebas y CI

- Puedes añadir pruebas de integración para:
  - Emisión y firma de facturas/boletas
  - Generación de PDF y presencia del QR y hash
  - Aprobación de SUNAT y respuestas (CDR)

- Ejemplos de pruebas pueden ubicarse en tests/

---

## Notas y consideraciones

- El hash se obtiene del DigestValue del XML firmado por SUNAT. En entornos beta puede haber variaciones; si DigestValue no está presente, se usará una ruta de respaldo.
- El QR se renderiza como data URI para evitar dependencias de red en el render de MPDF.
- Los roles de usuario están implementados para restringir áreas administrativas, con initial seeds para facilitar desarrollo y pruebas.

---

## Contribución

- Si deseas contribuir:
  - Crea una rama, añade tus cambios y abre un PR.
  - Por favor, añade tests para cualquier cambio significativo.

---

## Licencia

- MIT (u otra licencia definida en el repositorio)

---

