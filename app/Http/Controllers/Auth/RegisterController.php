<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return Application|Factory|View
     */
    public function Register(): View|Factory|Application
    {
        return view('auth/register');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function SaveRegister(Request $request) : JsonResponse
    {
        try {
            $usuario = new User();
            $usuario->Nombres = $request->get('Nombres');
            $usuario->Apellidos = $request->get('Apellidos');
            $usuario->Telefono = $request->get('Telefono');
            $usuario->Correo = $request->get('Correo');
            $splitName = explode(' ', $usuario->Apellidos, 2);
            $parteA = substr($usuario->Nombres, 0, 1);
            $parteB = !empty($splitName[0]) ? $splitName[0] : $usuario->Apellidos;
            $usuario->Username = strtolower($parteA.$parteB);
            $usuario->Password = Hash::make(strtolower($parteA.$parteB));
            $usuario->created_at = Carbon::now();
            $usuario->updated_at = null;
            $usuario->save();
            return response()->json(['success' => true, 'message' => 'Su usuario se registro correctamente, espere la confirmación del administrador.']);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
}
