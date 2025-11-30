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
        Schema::create('personalizaciones', function (Blueprint $table) {
            $table->id('id_personalizacion');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->text('descripcion');
            $table->string('tamano', 50);
            $table->string('sabor', 50);
            $table->string('ocasion', 50)->nullable();
            $table->integer('porciones');
            $table->string('imagen_referencia', 255)->nullable();
            $table->text('notas_adicionales')->nullable();
            $table->decimal('costo_estimado', 10, 2)->nullable();
            $table->enum('estado', ['Pendiente', 'En Diseño', 'Aprobado', 'Rechazado', 'Entregado'])
          ->default('Pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalizaciones');
    }
};
