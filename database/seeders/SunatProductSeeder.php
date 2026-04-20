<?php

namespace Database\Seeders;

use App\Models\SunatProduct;
use Illuminate\Database\Seeder;

class SunatProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['codigo' => '10000000', 'descripcion' => 'Animales vivos'],
            ['codigo' => '10000001', 'descripcion' => 'Carne de animales de la especie bovina'],
            ['codigo' => '10000002', 'descripcion' => 'Carne de animales de la especie porcina'],
            ['codigo' => '10000003', 'descripcion' => 'Carne de animales de la especie ovina'],
            ['codigo' => '10000004', 'descripcion' => 'Carne de animales de la especie caprina'],
            ['codigo' => '10000005', 'descripcion' => 'Carne de aves'],
            ['codigo' => '10000006', 'descripcion' => 'Pescados'],
            ['codigo' => '10000007', 'descripcion' => 'Crustáceos'],
            ['codigo' => '10000008', 'descripcion' => 'Leche'],
            ['codigo' => '10000009', 'descripcion' => 'Huevos'],
            ['codigo' => '10000010', 'descripcion' => 'Miel natural'],
            ['codigo' => '20000000', 'descripcion' => 'Tubérculos y raíces comestibles'],
            ['codigo' => '20000001', 'descripcion' => 'Legumbres'],
            ['codigo' => '20000002', 'descripcion' => 'Frutas'],
            ['codigo' => '20000003', 'descripcion' => 'Café'],
            ['codigo' => '20000004', 'descripcion' => 'Cacao'],
            ['codigo' => '20000005', 'descripcion' => 'Azúcar'],
            ['codigo' => '30000000', 'descripcion' => 'Cerveza'],
            ['codigo' => '30000001', 'descripcion' => 'Bebidas no alcohólicas'],
            ['codigo' => '30000002', 'descripcion' => 'Bebidas alcohólicas'],
            ['codigo' => '40000000', 'descripcion' => 'Sal'],
            ['codigo' => '40000001', 'descripcion' => 'Salsas'],
            ['codigo' => '40000002', 'descripcion' => 'Condimentos'],
            ['codigo' => '40000003', 'descripcion' => 'Harina de trigo'],
            ['codigo' => '40000004', 'descripcion' => 'Pastas alimenticias'],
            ['codigo' => '40000005', 'descripcion' => 'Panadería'],
            ['codigo' => '50000000', 'descripcion' => 'Petroleo'],
            ['codigo' => '50000001', 'descripcion' => 'Gasolina'],
            ['codigo' => '50000002', 'descripcion' => 'Diesel'],
            ['codigo' => '50000003', 'descripcion' => 'Gas natural'],
            ['codigo' => '51000000', 'descripcion' => 'Electricidad'],
            ['codigo' => '60000000', 'descripcion' => 'Medicamentos para uso humano'],
            ['codigo' => '60000001', 'descripcion' => 'Medicamentos veterinarios'],
            ['codigo' => '60000002', 'descripcion' => 'Vacunas'],
            ['codigo' => '70000000', 'descripcion' => 'Confección de prendas de vestir'],
            ['codigo' => '70000001', 'descripcion' => 'Calzado'],
            ['codigo' => '70000002', 'descripcion' => 'Cueros y pieles'],
            ['codigo' => '80000000', 'descripcion' => 'Muebles'],
            ['codigo' => '80000001', 'descripcion' => 'Madera y artículos de madera'],
            ['codigo' => '80000002', 'descripcion' => 'Material de construcción'],
            ['codigo' => '90000000', 'descripcion' => 'Servicios de transporte de carga'],
            ['codigo' => '90000001', 'descripcion' => 'Servicios de transporte de pasajeros'],
            ['codigo' => '90000002', 'descripcion' => 'Servicios de hospedaje'],
            ['codigo' => '90000003', 'descripcion' => 'Servicios de restaurante'],
            ['codigo' => '90000004', 'descripcion' => 'Servicios de educación'],
            ['codigo' => '90000005', 'descripcion' => 'Servicios de salud'],
            ['codigo' => '90000006', 'descripcion' => 'Servicios de telecomunicación'],
            ['codigo' => '90000007', 'descripcion' => 'Servicios de internet'],
            ['codigo' => '91000000', 'descripcion' => 'Construcción'],
            ['codigo' => '91000001', 'descripcion' => 'Consultoría y asesoramiento'],
            ['codigo' => '91000002', 'descripcion' => 'Servicios de información'],
            ['codigo' => '91000003', 'descripcion' => 'Servicios de publicidad'],
            ['codigo' => '92000000', 'descripcion' => 'Alquiler de vehículos'],
            ['codigo' => '92000001', 'descripcion' => 'Alquiler de maquinaria'],
            ['codigo' => '93000000', 'descripcion' => 'Servicios de mantenimiento'],
            ['codigo' => '94000000', 'descripcion' => 'Servicios de limpieza'],
            ['codigo' => '95000000', 'descripcion' => 'Servicios de seguridad'],
            ['codigo' => '96000000', 'descripcion' => 'Servicios de belleza y cuidado personal'],
            ['codigo' => '97000000', 'descripcion' => 'Servicios de entretenimiento'],
            ['codigo' => '98000000', 'descripcion' => 'Comisiones por representación'],
            ['codigo' => '98000001', 'descripcion' => 'Servicios de intermediación'],
            ['codigo' => '99000000', 'descripcion' => 'Otros servicios'],
        ];

        foreach ($products as $product) {
            SunatProduct::updateOrCreate(['codigo' => $product['codigo']], $product);
        }
    }
}