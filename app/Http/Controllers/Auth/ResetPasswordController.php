<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Realiza el cambio de contraseña del usuario actual
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ChangePassword(Request $request) : JsonResponse
    {
        try {
            $usuario = Auth::user();
            if(!Hash::check($request->get('Actual'), $usuario->Password))
                return response()->json(['success' => false, 'mensaje' => 'Contraseña incorrecta.']);
            if($request->get('Nueva') != $request->get('Repetir'))
                return response()->json(['success' => false, 'mensaje' => 'Las contraseñas no coinciden.']);
            $usuario->Password = Hash::make(strtolower($request->get('Nueva')));
            $usuario->save();
            return response()->json(['success' => true, 'mensaje' => 'Contraseña actualizada correctamente.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
