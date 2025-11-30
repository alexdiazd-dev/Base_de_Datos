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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('id_proveedor');
            $table->string('nombre', 120);
            $table->string('ruc', 15)->unique();
            $table->string('correo', 120)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
