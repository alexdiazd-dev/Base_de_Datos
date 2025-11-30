<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->bigIncrements('id_envio');
            $table->unsignedBigInteger('id_pedido');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('telefono', 20);
            $table->string('correo', 150);
            $table->string('direccion', 200);
            $table->string('ciudad', 100);
            $table->string('metodo_pago', 50);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->text('notas')->nullable();

            $table->foreign('id_pedido')
                ->references('id_pedido')
                ->on('pedidos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
