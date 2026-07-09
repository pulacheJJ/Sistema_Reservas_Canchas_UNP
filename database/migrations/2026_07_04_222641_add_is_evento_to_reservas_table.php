<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('reservas', function (Blueprint $table) {
        // Verificamos si la columna no existe antes de crearla
        if (!Schema::hasColumn('reservas', 'is_evento')) {
            $table->boolean('is_evento')->default(false)->after('estado');
        }
        if (!Schema::hasColumn('reservas', 'titulo_evento')) {
            $table->string('titulo_evento')->nullable()->after('is_evento');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            //
        });
    }
};
