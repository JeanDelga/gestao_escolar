<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\AlunoCurso;
use Illuminate\Http\Request;


class AlunoCursoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with('cursos')->get();
        $cursos = Curso::all();

        return view('aluno_curso.index', compact('alunos', 'cursos'));
    }

    public function create()
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();

        return view('aluno_curso.crud', compact('alunos', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        AlunoCurso::create([
            'aluno_id' => $request->aluno_id,
            'curso_id' => $request->curso_id,
        ]);

        return redirect()->route('aluno_curso.index')->with('success', 'Vínculo criado com sucesso!');
    }

    public function destroy($id)
    {
        $vinculo = AlunoCurso::findOrFail($id);
        $vinculo->delete();

        return redirect()->route('aluno_curso.index')->with('success', 'Vínculo removido com sucesso!');
    }
}
