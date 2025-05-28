<?php 

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;

class AlunoCursoController extends Controller
{
    public function index()
    {
        $vinculos = \DB::table('aluno_curso')
            ->join('alunos', 'aluno_curso.aluno_id', '=', 'alunos.id')
            ->join('cursos', 'aluno_curso.curso_id', '=', 'cursos.id')
            ->select('aluno_curso.*', 'alunos.nome as aluno_nome', 'cursos.nome as curso_nome')
            ->get();

        return view('aluno_curso.index', compact('vinculos'));
    }

    public function create()
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();
        $action = 'Cadastrar';
        return view('aluno_curso.crud', compact('alunos', 'cursos', 'action'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'curso_id' => 'required|exists:cursos,id'
        ]);

        \DB::table('aluno_curso')->insert([
            'aluno_id' => $request->aluno_id,
            'curso_id' => $request->curso_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('aluno_curso.index')->with('success', 'Aluno vinculado ao curso com sucesso!');
    }

    public function destroy($id)
    {
        \DB::table('aluno_curso')->where('id', $id)->delete();
        return redirect()->route('aluno_curso.index')->with('success', 'Vínculo removido com sucesso!');
    }
}
