<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * LOGIN
 */
Route::get('/', [LoginController::class, 'Login']);
Route::get('login', [LoginController::class, 'Login'])->name('login');
Route::post('login', [LoginController::class, 'Ingresar'])->name('Ingresar');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

/**
 * REGISTRO DE USUARIOS
 */
Route::get('registro', [RegisterController::class, 'Register'])->name('Register');
Route::post('registro', [RegisterController::class, 'SaveRegister'])->name('SaveRegister');

/**
 * HOME
 */
Route::get('home', [HomeController::class, 'Home'])->name('home');

/**
 * USUARIOS
 */
Route::get('Usuarios', [UserController::class, 'GetUsuarios'])->name('GetUsuarios');
Route::post('Usuarios/Create/', [UserController::class, 'Create'])->name('UsuariosCreate');
Route::post('Usuarios/Update/{IdUsuario}', [UserController::class, 'Update'])->name('UsuariosUpdate');
Route::post('Usuarios/Delete/{IdUsuario}', [UserController::class, 'Delete'])->name('UsuariosDelete');
Route::post('Usuarios/Verificate/{IdUsuario}', [UserController::class, 'Verificate'])
    ->name('UsuariosVerificate');
Route::post('Usuarios/ChangePassword', [ResetPasswordController::class, 'ChangePassword'])
    ->name('UsuariosChangePassword');

/**
 * TABS
 */
Route::get('Evaluaciones', [EvaluacionController::class, 'GetEvaluaciones'])->name('GetEvaluaciones');
Route::get('Evaluacion/{IdRegistro}', [EvaluacionController::class, 'GetEvaluacion'])->name('GetEvaluacion');

/**
 * REGISTRO
 */
Route::get('Registro/{IdRegistro}', [RegistroController::class, 'GetRegistro'])->name('GetRegistro');
Route::post('Registro/Create/', [RegistroController::class, 'RegistroCreate'])->name('RegistroCreate');
Route::post('Registro/Update/{IdRegistro}', [RegistroController::class, 'RegistroUpdate'])->name('RegistroUpdate');
Route::post('Registro/Delete/{IdRegistro}', [RegistroController::class, 'RegistroDelete'])->name('RegistroDelete');

/**
 * TEMA
 */
Route::get('Tema/{IdRegistro}', [TemaController::class, 'GetTema'])->name('GetTema');
Route::post('Tema/Create/', [TemaController::class, 'TemaCreate'])->name('TemaCreate');
Route::post('Tema/Update/{IdTema}', [TemaController::class, 'TemaUpdate'])->name('TemaUpdate');

/**
 * RESULTADO
 */
Route::get('Resultado/{IdRegistro}', [ResultadoController::class, 'GetResultado'])->name('GetResultado');
