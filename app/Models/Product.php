<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'codigo', 'descripcion', 'codigo_sunat',
        'umedida_codigo', 'precio', 'precio_minimo', 'tipo_afectacion',
        'igv_percent', 'estado'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}