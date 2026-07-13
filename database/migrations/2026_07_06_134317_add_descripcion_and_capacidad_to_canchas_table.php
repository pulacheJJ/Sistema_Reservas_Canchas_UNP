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
        try {
            Schema::table('canchas', function (Blueprint $table) {
                // Verificamos si la tabla existe antes de intentar alterar
                if (Schema::hasTable('canchas')) {
                    if (!Schema::hasColumn('canchas', 'descripcion')) {
                        $table->text('descripcion')->nullable()->after('tipo');
                    }
                    if (!Schema::hasColumn('canchas', 'capacidad')) {
                        $table->integer('capacidad')->default(10)->after('descripcion');
                    }
                }
            });
        } catch (\Exception $e) {
            // Si falla por alguna razón (como que la tabla aún no existe), 
            // simplemente lo registramos pero permitimos que el despliegue continúe.
            \Log::warning("Migración de canchas saltada: " . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
            $table->dropColumn(['descripcion', 'capacidad']);
        });
    }
};
