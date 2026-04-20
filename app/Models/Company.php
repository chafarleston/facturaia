<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc', 'razon_social', 'nombre_comercial', 'direccion',
        'departamento', 'provincia', 'distrito', 'ubigeo',
        'telefono', 'email', 'logo', 'certificado_path',
        'certificado_password', 'certificado_vence',
        'tipo_contribuyente', 'estado',
        'soap_type_id', 'soap_username', 'soap_password', 'certificate'
    ];

    public function hasCertificate()
    {
        return $this->certificate && file_exists(storage_path('app/certificates/' . $this->certificate));
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function series()
    {
        return $this->hasMany(Serie::class);
    }
    
    public static function getMainCompany()
    {
        $company = self::where('is_main', true)->first();
        if (!$company) {
            $company = self::where('estado', 'ACTIVO')->first();
        }
        return $company;
    }
}