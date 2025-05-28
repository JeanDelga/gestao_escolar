<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Nota::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route("notas.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        <form action="' . route("notas.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('notas.index');
    }

    public function create()
    {
        $action = 'Criar';
        $alunos = Aluno::all();
        $cursos = Curso::all();
        $disciplinas = Disciplina::all();
        return view('notas.crud', compact('action', 'alunos', 'cursos', 'disciplinas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $edit = new Nota();
        $edit->aluno_id = $request->post('aluno_id');
        $edit->curso_id = $request->post('curso_id');
        $edit->disciplina_id = $request->post('disciplina_id');
        $edit->valor = $request->post('valor');
        $edit->save();

        return view('notas.index');
    }

    public function edit($id)
    {
        $edit = Nota::find($id);
        $action = 'Editar';
        $alunos = Aluno::all();
        $cursos = Curso::all();
        $disciplinas = Disciplina::all();
        return view('notas.crud', compact('edit', 'action', 'alunos', 'cursos', 'disciplinas'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $edit = Nota::find($id);
        $edit->aluno_id = $request->post('aluno_id');
        $edit->curso_id = $request->post('curso_id');
        $edit->disciplina_id = $request->post('disciplina_id');
        $edit->valor = $request->post('valor');
        $edit->update();

        return view('notas.index');
    }

    public function destroy($id)
    {
        $edit = Nota::find($id);
        $edit->delete();

        return view('notas.index');
    }
}
