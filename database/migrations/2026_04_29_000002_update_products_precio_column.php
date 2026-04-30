<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE products MODIFY precio DECIMAL(12,2) DEFAULT 0");
    }

    public function down()
    {
        DB::statement("ALTER TABLE products MODIFY precio DECIMAL(12,2) NOT NULL");
    }
};