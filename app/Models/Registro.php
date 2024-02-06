<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Registro extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "registro";
    protected $primaryKey = "IdRegistro";
    protected $fillable = [
        "IdRegistro",
        "IdUsuario",
        "Nombres",
        "Apellidos",
        "Correo",
        "CarreraProfesional",
        "Maestria",
        "Doctorado",
        "Otro",
        "Pais",
        "Departamento"
    ];
}
