<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla detalle_pedidos
     */
    public function up(): void
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {

            // ID autoincrementable
            $table->bigIncrements('id_detalle');

            // Relaciones
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_producto');

            // Datos
            $table->integer('cantidad');
            $table->decimal('subtotal', 10, 2);

            // Foreign keys
            $table->foreign('id_pedido')
                  ->references('id_pedido')
                  ->on('pedidos')
                  ->onDelete('cascade');

            $table->foreign('id_producto')
                  ->references('id_producto')
                  ->on('productos');

            // Sin timestamps porque tu tabla original no los usa
            // $table->timestamps();
        });
    }

    /**
     * Eliminar tabla
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
