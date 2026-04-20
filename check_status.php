<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$invoice = App\Models\Invoice::latest()->first();

echo "Invoice: " . $invoice->full_number . "\n";
echo "sunat_code: " . ($invoice->sunat_code ?? 'NULL') . "\n";
echo "sunat_description: " . ($invoice->sunat_description ?? 'NULL') . "\n";
echo "sunat_estado: " . ($invoice->sunat_estado ?? 'NULL') . "\n";
echo "sunat_response: " . ($invoice->sunat_response ?? 'NULL') . "\n";