<?php

namespace App\Http\Controllers;

use App\Models\Presenca;
use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;

class PresencaController extends Controller
{
    public function index()
    {
        $presencas = Presenca::with(['aluno', 'curso'])->get();
        return view('presencas.index', compact('presencas'));
    }

    public function create()
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();
        return view('presencas.create', compact('alunos', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'curso_id' => 'required|exists:cursos,id',
            'data' => 'required|date',
            'presente' => 'required|boolean',
        ]);

        Presenca::create($request->all());

        return redirect()->route('presencas.index')->with('success', 'Presença registrada com sucesso!');
    }

    public function show(Presenca $presenca)
    {
        return view('presencas.show', compact('presenca'));
    }

    public function edit(Presenca $presenca)
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();
        return view('presencas.edit', compact('presenca', 'alunos', 'cursos'));
    }

    public function update(Request $request, Presenca $presenca)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'curso_id' => 'required|exists:cursos,id',
            'data' => 'required|date',
            'presente' => 'required|boolean',
        ]);

        $presenca->update($request->all());

        return redirect()->route('presencas.index')->with('success', 'Presença atualizada com sucesso!');
    }

    public function destroy(Presenca $presenca)
    {
        $presenca->delete();

        return redirect()->route('presencas.index')->with('success', 'Presença excluída com sucesso!');
    }
}
