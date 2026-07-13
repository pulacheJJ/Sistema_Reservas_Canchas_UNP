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
        Schema::table('canchas', function (Blueprint $table) {
            if (!Schema::hasColumn('canchas', 'descripcion')) {
                $table->text('descripcion')->nullable();
            }
            if (!Schema::hasColumn('canchas', 'capacidad')) {
                $table->integer('capacidad')->default(10);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
