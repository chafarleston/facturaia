<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$company = App\Models\Company::whereNotNull('certificado_path')->first();

echo "Company RUC: " . $company->ruc . "\n";
echo "Company razon_social: " . $company->razon_social . "\n";
echo "Company direccion: " . $company->direccion . "\n";
echo "Company ubigeo: " . ($company->ubigeo ?? 'NULL') . "\n";