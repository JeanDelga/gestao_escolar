<?php

namespace App\Http\Controllers;

use App\Models\Presenca;
use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PresencaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Presenca::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route("presencas.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        <form action="' . route("presencas.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('presencas.index');
    }

    public function create()
    {
        $action = 'Criar';
        $alunos = Aluno::all();
        $cursos = Curso::all();
        return view('presencas.crud', compact('action', 'alunos', 'cursos'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $edit = new Presenca();
        $edit->aluno_id = $request->post('aluno_id');
        $edit->curso_id = $request->post('curso_id');
        $edit->data = $request->post('data');
        $edit->presente = $request->post('presente');
        $edit->save();

        return view('presencas.index');
    }

    public function edit($id)
    {
        $edit = Presenca::find($id);
        $action = 'Editar';
        $alunos = Aluno::all();
        $cursos = Curso::all();
        return view('presencas.crud', compact('edit', 'action', 'alunos', 'cursos'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $edit = Presenca::find($id);
        $edit->aluno_id = $request->post('aluno_id');
        $edit->curso_id = $request->post('curso_id');
        $edit->data = $request->post('data');
        $edit->presente = $request->post('presente');
        $edit->update();

        return view('presencas.index');
    }

    public function destroy($id)
    {
        $edit = Presenca::find($id);
        $edit->delete();

        return view('presencas.index');
    }
}
