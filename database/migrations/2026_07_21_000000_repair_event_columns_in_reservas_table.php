<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Repara instalaciones donde la migración original quedó registrada,
     * pero las columnas de eventos no llegaron a crearse.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('reservas', 'is_evento')) {
            Schema::table('reservas', function (Blueprint $table) {
                $table->boolean('is_evento')->default(false)->after('estado');
            });
        }

        if (! Schema::hasColumn('reservas', 'titulo_evento')) {
            Schema::table('reservas', function (Blueprint $table) {
                $table->string('titulo_evento')->nullable()->after('is_evento');
            });
        }
    }

    /**
     * No se eliminan columnas durante un rollback para proteger eventos existentes.
     */
    public function down(): void
    {
        // Migración correctiva no destructiva.
    }
};
