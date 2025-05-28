<?php 

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Presenca;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PresencaController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view('presencas.index', compact('cursos'));
    }

    public function getAlunos($cursoId)
    {
        $curso = Curso::with('alunos')->find($cursoId);
        return response()->json($curso->alunos);
    }

    public function store(Request $request)
    {
        $data = $request->data;
        $cursoId = $request->curso_id;

        foreach ($request->presencas as $alunoId => $presente) {
            Presenca::create([
                'aluno_id' => $alunoId,
                'curso_id' => $cursoId,
                'data' => $data,
                'presente' => $presente === '1' ? true : false,
            ]);
        }

        return redirect()->route('presencas.index')->with('success', 'Presenças registradas com sucesso!');
    }
}
