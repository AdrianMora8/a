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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas con RESTRICT
            $table->foreignId('cliente_id')->constrained()->onDelete('restrict');
            $table->foreignId('producto_id')->constrained()->onDelete('restrict');
            
            $table->integer('cantidad');
            $table->decimal('total', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
