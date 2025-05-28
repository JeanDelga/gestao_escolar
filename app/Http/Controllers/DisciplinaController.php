<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DisciplinaController extends Controller
{
    public function index()
    {
        $disciplinas = Disciplina::whereHas('curso', function ($query) {
            $query->where('professor_id', auth()->id());
        })->get();

        return view('disciplinas.index', compact('disciplinas'));
    }

    public function create()
    {
        $action = 'Criar';
        $disciplina = null;

        $cursos = Curso::where('professor_id', auth()->id())->get();

        return view('disciplinas.crud', compact('action', 'disciplina', 'cursos'));
    }

    public function store(Request $request)
    {
        $disciplina = new Disciplina();
        $disciplina->nome = $request->nome;
        $disciplina->descricao = $request->descricao;
        $disciplina->curso_id = $request->curso_id;
        $disciplina->save();

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina criada com sucesso!');
    }

    public function edit(Disciplina $disciplina)
    {
        if (Gate::denies('manage-discipline', $disciplina)) {
            abort(403);
        }

        $action = 'Editar';

        $cursos = Curso::where('professor_id', auth()->id())->get();

        return view('disciplinas.crud', compact('action', 'disciplina', 'cursos'));
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        if (Gate::denies('manage-discipline', $disciplina)) {
            abort(403);
        }

        $disciplina->nome = $request->nome;
        $disciplina->descricao = $request->descricao;
        $disciplina->curso_id = $request->curso_id;
        $disciplina->save();

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina atualizada com sucesso!');
    }

    public function destroy(Disciplina $disciplina)
    {
        if (Gate::denies('manage-discipline', $disciplina)) {
            abort(403);
        }

        $disciplina->delete();

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina excluída com sucesso!');
    }
}
