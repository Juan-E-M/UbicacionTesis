<?php

namespace App\Http\Controllers;

use App\Models\Tema;

class ResultadoController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Retorna la vista de nivelacion
     *
     */
    public function GetResultado($IdRegistro)
    {
        $tema = Tema::where('IdRegistro', '=', $IdRegistro)->first();
        if ($tema == null) {
            $resultado = 0;
            $tiempo = 0;
            $requerimientos = 0;
        }
        else {
            $tiempo = $tema->Tiempo;
            $requerimientos = $tema->Requerimientos;
            $resultado = $tiempo + $requerimientos;
        }
        return view('evaluacion/resultado', ['tiempo'=>$tiempo, 'requerimientos'=>$requerimientos,
            'resultado'=>$resultado]);
    }
}
