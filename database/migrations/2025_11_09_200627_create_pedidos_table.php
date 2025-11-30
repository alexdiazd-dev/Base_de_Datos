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
            $table->id('id_pedido');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->timestamp('fecha_pedido')->useCurrent();
            $table->enum('estado', ['Pendiente','Preparación','Enviado','Entregado','Cancelado'])->default('Pendiente');
            $table->decimal('total', 10, 2);
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
