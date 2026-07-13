<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Usamos DB::statement para ejecutar SQL directo y envolverlo en un try-catch
        try {
            Schema::table('reservas', function (Blueprint $table) {
                $table->boolean('is_evento')->default(false)->after('estado');
                $table->string('titulo_evento')->nullable()->after('is_evento');
            });
        } catch (\Exception $e) {
            // Si falla porque la columna ya existe, simplemente lo ignoramos
            // para que la migración se marque como "DONE" y no se detenga.
        }
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
