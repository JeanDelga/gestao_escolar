<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        $notas = Nota::with(['aluno', 'curso', 'disciplina'])->get();
        return view('notas.index', compact('notas'));
    }

    public function create()
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();
        $disciplinas = Disciplina::all();
        return view('notas.create', compact('alunos', 'cursos', 'disciplinas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'curso_id' => 'required|exists:cursos,id',
            'disciplina_id' => 'required|exists:disciplinas,id',
            'valor' => 'required|numeric|between:0,10',
        ]);

        Nota::create($request->all());

        return redirect()->route('notas.index')->with('success', 'Nota lançada com sucesso!');
    }

    public function show(Nota $nota)
    {
        return view('notas.show', compact('nota'));
    }

    public function edit(Nota $nota)
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();
        $disciplinas = Disciplina::all();
        return view('notas.edit', compact('nota', 'alunos', 'cursos', 'disciplinas'));
    }

    public function update(Request $request, Nota $nota)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'curso_id' => 'required|exists:cursos,id',
            'disciplina_id' => 'required|exists:disciplinas,id',
            'valor' => 'required|numeric|between:0,10',
        ]);

        $nota->update($request->all());

        return redirect()->route('notas.index')->with('success', 'Nota atualizada com sucesso!');
    }

    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()->route('notas.index')->with('success', 'Nota excluída com sucesso!');
    }
}
