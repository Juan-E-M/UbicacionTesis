<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return Factory|View|Application
     */
    public function Login(): Factory| View| Application
    {
        try {
            if(Auth::check())
                return view('home');
            return view('auth/login', ['error' => null]);
        }
        catch (Exception $exception){
            return view('error', [ 'error' => $exception->getMessage() ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|Factory|View|Application
     */
    public function Ingresar(Request $request) : JsonResponse|Factory| View| Application
    {
        try {
            $user = User::whereUsername($request->get('Username'))->first();
            if ($user == null)
                return view('auth/login', ['error' => 'Usuario incorrecto.']);
            if(!Hash::check($request->get('Password'), $user->Password))
                return view('auth/login', ['error' => 'Contraseña incorrecta.']);
            // if(!$user->EsVerificado)
            //     return view('auth/login', ['error' => 'Usuario no verificado.']);
            Auth::loginUsingId($user->IdUsuario);
            return view('home', []);
        } catch (Exception $exception) {
            return view('auth/login', ['error' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function logout(Request $request): Application|Factory|View|JsonResponse
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return view('auth/login', ['error' => null]);
        }
        catch (Exception $exception){
            return response()->json(array('success' => false, 'error' => $exception->getMessage()), 500);
        }
    }
}
