<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // En MySQL, modificamos el ENUM para incluir 'administrativo'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'estudiante', 'docente', 'administrativo') DEFAULT 'estudiante' NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a la versión anterior
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'estudiante', 'docente') DEFAULT 'estudiante' NOT NULL");
    }
};
