<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna todas las evaluaciones según el usuario actual
     *
     * @return Factory|View|Application
     */
    public function GetEvaluaciones(): Factory| View| Application
    {
        if (Auth::user()->EsAdmin)
            $evaluaciones = Registro::orderBy('IdRegistro', 'DESC')->get();
        else
            $evaluaciones = Registro::where('IdUsuario', '=', Auth::id())->orderBy('IdRegistro', 'DESC')->get();
        return view('evaluacion/index', ['evaluaciones'=>$evaluaciones]);
    }

    /**
     * Retorna la evaluación actual según el IdRegistro actual
     *
     * @param $IdRegistro
     * @return Factory|View|Application
     */
    public function GetEvaluacion($IdRegistro): Factory| View| Application
    {
        return view('evaluacion/tabs', ['IdRegistro'=>$IdRegistro]);
    }
}
