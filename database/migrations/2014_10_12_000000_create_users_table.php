<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function (Blueprint $table) {
            $table->id("IdUsuario");
            $table->string("Nombres");
            $table->string("Apellidos");
            $table->string("Telefono");
            $table->string("Correo")->unique();
            $table->string("Username")->unique();
            $table->string("Password");
            $table->boolean("EsAdmin")->default(0);
            $table->boolean("EsVerificado")->default(0);
            $table->timestamps();
        });

        Schema::create("registro", function (Blueprint $table) {
            $table->id("IdRegistro");
            $table->integer("IdUsuario");
            $table->string("Nombres");
            $table->string("Apellidos");
            $table->string("Correo");
            $table->string("CarreraProfesional");
            $table->string("Maestria")->nullable();
            $table->string("Doctorado")->nullable();
            $table->text("Otro")->nullable();
            $table->string("Pais")->nullable();
            $table->string("Departamento")->nullable();
            $table->timestamps();
        });

        Schema::create("tema", function (Blueprint $table) {
            $table->id("IdTema");
            $table->integer("IdRegistro");
            $table->string("CursoGustado");
            $table->string("DondeTrabaja");
            $table->string("DondeQuiereTrabaja");
            $table->string("PorqueDeseasGrado");
            $table->integer("Tiempo");
            $table->integer("Requerimientos");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users");
        Schema::dropIfExists("registro");
        Schema::dropIfExists("tema");
    }
};
