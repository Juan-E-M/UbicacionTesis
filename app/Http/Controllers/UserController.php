<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna los usuarios actuales del sistema
     *
     * @return Application|Factory|View
     */
    public function GetUsuarios(): View|Factory|Application
    {
        try {
            $usuarios = User::orderBy('IdUsuario', 'DESC')->get();
            return view('usuario/index', ['usuarios' => $usuarios]);
        } catch (Exception $exception) {
            return view('error', ['error' => $exception->getMessage()]);
        }
    }

    /**
     * Registra un nuevo usuario en el sistema
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function Create(Request $request) : JsonResponse
    {
        try {
            $usuario = $this->Factory(new User(), $request, true);
            return response()->json(['success' => true, 'mensaje' => 'Usuario creado correctamente.',
                'usuario' => $usuario]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualiza un usuario existente en el sistema
     *
     * @param Request $request
     * @param $IdUsuario
     * @return JsonResponse
     * @throws ValidationException
     */
    public function Update(Request $request, $IdUsuario) : JsonResponse
    {
        try {
            $usuario = User::where('IdUsuario', $IdUsuario)->first();
            if ($usuario == null)
                return response()->json(['success' => false,
                    'mensaje' => 'No se encontró al usuario con Id: '.$IdUsuario.'.'], 404);
            $usuario = $this->Factory($usuario, $request, false);
            return response()->json(['success' => true, 'mensaje' => 'Usuario actualizado correctamente.', 'usuario' => $usuario]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Elimina un usuario según su IdUsuario
     *
     * @param $IdUsuario
     * @return JsonResponse
     */
    public function Delete($IdUsuario) : JsonResponse
    {
        try {
            $usuario = User::where('IdUsuario', $IdUsuario)->first();
            if ($usuario == null)
                return response()->json(['success' => false,
                    'mensaje' => 'No se encontró al usuario con Id: '.$IdUsuario.'.'], 404);
            $usuario->delete();
            return response()->json(['success' => true, 'mensaje' => 'Usuario eliminado correctamente.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Actualiza el estado de verificación de la cuenta de un usuario
     *
     * @param $IdUsuario
     * @return JsonResponse
     */
    public function Verificate($IdUsuario) : JsonResponse
    {
        try {
            $usuario = User::where('IdUsuario', $IdUsuario)->first();
            if ($usuario == null)
                return response()->json(['success' => false,
                    'mensaje' => 'No se encontró al usuario con Id: '.$IdUsuario.'.'], 404);
            $usuario->EsVerificado = 1;
            $usuario->save();
            return response()->json(['success' => true, 'mensaje' => 'Usuario verificado correctamente.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Método que llena los datos del objeto de tipo User
     *
     * @param User $usuario
     * @param Request $request
     * @param bool $esNuevo
     * @return User
     */
    private function Factory(User $usuario, Request $request, bool $esNuevo) : User
    {
        $usuario->Nombres = $request->get('Nombres');
        $usuario->Apellidos = $request->get('Apellidos');
        $usuario->Telefono = $request->get('Telefono');
        $usuario->Correo = $request->get('Correo');
        if($esNuevo)
        {
            $splitName = explode(' ', $usuario->Apellidos, 2);
            $parteA = substr($usuario->Nombres, 0, 1);
            $parteB = !empty($splitName[0]) ? $splitName[0] : $usuario->Apellidos;
            $usuario->Username = strtolower($parteA.$parteB);
            $usuario->Password = Hash::make(strtolower($parteA.$parteB));
            $usuario->created_at = Carbon::now();
            $usuario->updated_at = null;
        }
        else
            $usuario->updated_at = Carbon::now();
        $usuario->save();
        return $usuario;
    }
}
