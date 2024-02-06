<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Tema;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemaController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna el tema relacionado con el IdTema
     *
     * @param $IdRegistro
     * @return Factory|View|Application
     */
    public function GetTema($IdRegistro): Factory| View| Application
    {
        $tema = Tema::where('IdRegistro', '=', $IdRegistro)->first();
        $registro = Registro::where('IdRegistro', '=', $IdRegistro)->first();
        return view('evaluacion/tema', ['registro'=>$registro, 'tema'=>$tema]);
    }

    /**
     * Guarda la información del tema
     * @param Request $request
     * @return JsonResponse
     */
    public function TemaCreate(Request $request): JsonResponse
    {
        try
        {
            $tema = new Tema;
            $tema = $this->Factory($tema, $request);
            $tema->save();
            return response()->json(array('success' => true, 'message' => 'Tema guardado correctamente.',
                'registro' => $tema), 200);
        }
        catch (Exception $exception) {
            return response()->json(array('success' => false, 'message' => $exception->getMessage()), 500);
        }
    }

    /**
     * Actualiza la información del tema
     * @param Request $request
     * @param $IdTema
     * @return JsonResponse
     */
    public function TemaUpdate(Request $request, $IdTema): JsonResponse
    {
        try
        {
            $tema = Tema::where('IdTema', '=', $IdTema)->first();
            $tema = $this->Factory($tema, $request);
            $tema->save();
            return response()->json(array('success' => true, 'message' => 'Tema actualizado correctamente.',
                'registro' => $tema), 200);
        }
        catch (Exception $exception) {
            return response()->json(array('success' => false, 'message' => $exception->getMessage()), 500);
        }
    }

    /**
     * Llena la información del tema
     * @param Tema $tema
     * @param Request $request
     * @return Tema
     */
    private function Factory(Tema $tema, Request $request): Tema
    {
        $tema->IdRegistro = $request->get('IdRegistro');
        $tema->CursoGustado = $request->get('CursoGustado');
        $tema->DondeTrabaja = $request->get('DondeTrabaja');
        $tema->DondeQuiereTrabaja = $request->get('DondeQuiereTrabaja');
        $tema->PorqueDeseasGrado = $request->get('PorqueDeseasGrado');
        $tema->Tiempo = $request->get('Tiempo');
        $tema->Requerimientos = $request->get('Requerimientos');
        return $tema;
    }
}
