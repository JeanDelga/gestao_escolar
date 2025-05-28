<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\AlunoCursoController;
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

Route::get('notas/lancar', [NotaController::class, 'lancar'])->name('notas.lancar');
Route::post('notas/salvar', [NotaController::class, 'salvar'])->name('notas.salvar');

Route::get('notas/disciplinas/{curso}', [NotaController::class, 'getDisciplinas']);
Route::get('notas/alunos/{curso}', [NotaController::class, 'getAlunos']);

oute::get('aluno-curso', [AlunoCursoController::class, 'index'])->name('aluno_curso.index');
Route::get('aluno-curso/create', [AlunoCursoController::class, 'create'])->name('aluno_curso.create');
Route::post('aluno-curso', [AlunoCursoController::class, 'store'])->name('aluno_curso.store');
Route::delete('aluno-curso/{id}', [AlunoCursoController::class, 'destroy'])->name('aluno_curso.destroy');
