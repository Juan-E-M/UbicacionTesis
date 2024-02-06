<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Tema extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "tema";
    protected $primaryKey = "IdTema";
    protected $fillable = [
        "IdTema",
        "IdRegistro",
        "CursoGustado",
        "DondeTrabaja",
        "DondeQuiereTrabaja",
        "PorqueDeseasGrado",
        "Tiempo",
        "Requerimientos"
    ];
}
