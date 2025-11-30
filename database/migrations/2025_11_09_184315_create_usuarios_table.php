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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->foreignId('id_rol')->constrained('roles', 'id_rol');;
            $table->string('nombre', 80);
            $table->string('apellido', 80);
            $table->string('correo', 120)->unique();
            $table->string('contraseña', 255);
            $table->string('telefono', 20)->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
