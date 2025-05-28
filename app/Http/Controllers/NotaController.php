<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotaController extends Controller
{
    // Formulário de lançamento de notas
    public function index()
    {
        $cursos = Curso::where('professor_id', auth()->id())->get();
        return view('notas.index', compact('cursos'));
    }

    // Salva as notas em lote
    public function salvar(Request $request)
    {
        foreach($request->notas as $aluno_id => $valor) {
            Nota::updateOrCreate(
                [
                    'aluno_id' => $aluno_id,
                    'disciplina_id' => $request->disciplina_id
                ],
                [
                    'nota' => $valor
                ]
            );
        }

        return redirect()->back()->with('success', 'Notas lançadas com sucesso!');
    }

    // Retorna disciplinas do curso via JSON
    public function getAlunos($cursoId)
    {
        $alunos = Aluno::whereHas('cursos', function($query) use ($cursoId) {
            $query->where('curso_id', $cursoId);
        })->get();

        return response()->json($alunos);
    }

    public function getDisciplinas($cursoId)
    {
        $disciplinas = Disciplina::where('curso_id', $cursoId)->get();
        return response()->json($disciplinas);
    }

}
