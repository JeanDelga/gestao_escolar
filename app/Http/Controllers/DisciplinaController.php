<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\Curso;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index()
    {
        $disciplinas = Disciplina::all();
        return view('disciplinas.index', compact('disciplinas'));
    }

    public function create()
    {
        $cursos = Curso::all();
        return view('disciplinas.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Disciplina::create($request->all());

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina criada com sucesso!');
    }

    public function show(Disciplina $disciplina)
    {
        return view('disciplinas.show', compact('disciplina'));
    }

    public function edit(Disciplina $disciplina)
    {
        $cursos = Curso::all();
        return view('disciplinas.edit', compact('disciplina', 'cursos'));
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        $request->validate([
            'nome' => 'required|string',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $disciplina->update($request->all());

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina atualizada com sucesso!');
    }

    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina excluída com sucesso!');
    }
}
