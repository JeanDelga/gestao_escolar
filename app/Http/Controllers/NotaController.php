<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Aluno;
use App\Models\Nota;

class NotaController extends Controller
{
    public function index()
    {
        return view('notas.index');
    }

    public function create()
    {
        $cursos = Curso::all();
        return view('notas.crud', compact('cursos'));
    }

    public function store(Request $request)
{
    $disciplinaId = $request->disciplina;

    foreach($request->notas as $alunoId => $notaValor) {
        Nota::create([
            'aluno_id' => $alunoId,
            'disciplina_id' => $disciplinaId,
            'valor' => $notaValor['valor'],
        ]);
    }

    return redirect()->route('notas.index')->with('success', 'Notas lançadas com sucesso!');
}


    public function getDisciplinas($cursoId)
    {
        $disciplinas = Disciplina::where('curso_id', $cursoId)->get();
        return response()->json($disciplinas);
    }

    public function getAlunos($cursoId)
    {
        $alunos = Aluno::whereHas('cursos', function($query) use ($cursoId) {
            $query->where('curso_id', $cursoId);
        })->get();

        return response()->json($alunos);
    }
}
