<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Models\Registro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna la vista principal de registro.
     * @param $IdRegistro
     * @return Factory|View|Application
     */
    public function GetRegistro($IdRegistro): Factory| View| Application
    {
        $registro = Registro::where('IdRegistro', '=', $IdRegistro)->first();
        return view('evaluacion/registro', ['registro' => $registro]);
    }

    /**
     * Guarda la informacion de registro
     * @param Request $request
     * @return JsonResponse
     */
    public function RegistroCreate(Request $request): JsonResponse
    {
        try
        {
            $registro = new Registro;
            $registro = $this->Factory($registro, $request);
            $registro->save();
            return response()->json(array('success' => true, 'message' => 'Registro guardado correctamente.',
                'registro' => $registro), 200);
        }
        catch (Exception $exception) {
            return response()->json(array('success' => false, 'message' => $exception->getMessage()), 500);
        }
    }

    /**
     * Actualiza la información de registro
     * @param Request $request
     * @param $IdRegistro
     * @return JsonResponse
     */
    public function RegistroUpdate(Request $request, $IdRegistro): JsonResponse
    {
        try
        {
            $registro = Registro::where('IdRegistro', '=', $IdRegistro)->first();
            $registro = $this->Factory($registro, $request);
            $registro->save();
            return response()->json(array('success' => true, 'message' => 'Registro actualizado correctamente.',
                'registro' => $registro), 200);
        }
        catch (Exception $exception) {
            return response()->json(array('success' => false, 'message' => $exception->getMessage()), 500);
        }
    }

    /**
     * Elimina la información de registro y las tablas relacionado con este
     * @param $IdRegistro
     * @return JsonResponse
     */
    public function RegistroDelete($IdRegistro): JsonResponse
    {
        try
        {
            Tema::where('IdRegistro', '=', $IdRegistro)->delete();
            Registro::where('IdRegistro', '=', $IdRegistro)->first()->delete();
            return response()->json(array('success' => true, 'message' => 'Registro eliminado correctamente.'), 200);
        }
        catch (Exception $exception) {
            return response()->json(array('success' => false, 'message' => $exception->getMessage()), 500);
        }
    }

    /**
     * Llena la información de registro
     * @param Registro $registro
     * @param Request $request
     * @return Registro
     */
    private function Factory(Registro $registro, Request $request): Registro
    {
        $registro->IdUsuario = Auth::id();
        $registro->Nombres = $request->get('Nombres');
        $registro->Apellidos = $request->get('Apellidos');
        $registro->Correo = $request->get('Correo');
        $registro->CarreraProfesional = $request->get('CarreraProfesional');
        $registro->Maestria = $request->get('Maestria');
        $registro->Doctorado = $request->get('Doctorado');
        $registro->Otro = $request->get('Otro');
        $registro->Pais = $request->get('Pais');
        $registro->Departamento = $request->get('Departamento');
        return $registro;
    }
}
