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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cedula');
            $table->string('direccion');
            $table->date('fecha_contratacion');
            $table->string('foto_perfil')->nullable();

            $table->foreignId('id_rol')->constrained('roles');
            $table->foreignId('id_puesto')->nullable()->constrained('puestos');
            $table->foreignId('id_salario')->nullable()->constrained('salarios');

            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
