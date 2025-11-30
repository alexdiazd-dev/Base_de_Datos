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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido');
            $table->enum('metodo_pago', ['Yape', 'Plin', 'Tarjeta', 'Contra Entrega']);
            $table->timestamp('fecha_pago')->useCurrent();
            $table->decimal('monto', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
