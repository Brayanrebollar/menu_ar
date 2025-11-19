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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('info_nutricional')->nullable();
            $table->text('info_cultural')->nullable();
            $table->text('ingredientes')->nullable();
            $table->decimal('precio', 8, 2);
            $table->foreignId('categoria_id')->constrained('food_categories');
            $table->string('imagen')->nullable();     // foto del platillo
            $table->string('modelo_3d')->nullable();  // archivo 3D
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
