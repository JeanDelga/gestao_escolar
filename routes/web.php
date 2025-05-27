<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\DisciplinaController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('alunos', AlunoController::class);
Route::resource('cursos', CursoController::class);
Route::resource('disciplinas', DisciplinaController::class);
Route::resource('notas', NotaController::class);
Route::resource('presencas', PresencaController::class);
Route::resource('usuarios', UserController::class);