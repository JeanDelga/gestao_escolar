<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Curso::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route("cursos.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        <form action="' . route("cursos.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('cursos.index');
    }

    public function create()
    {
        $action = 'Criar';
        $professores = User::where('role', 'professor')->get();
        return view('cursos.crud', compact('action', 'professores'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $edit = new Curso();
        $edit->nome = $request->post('nome');
        $edit->carga_horaria = $request->post('carga_horaria');
        $edit->professor_id = $request->post('professor_id');
        $edit->save();

        return view('cursos.index');
    }

    public function edit($id)
    {
        $edit = Curso::find($id);
        $action = 'Editar';
        $professores = User::where('role', 'professor')->get();
        return view('cursos.crud', compact('edit', 'action', 'professores'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $edit = Curso::find($id);
        $edit->nome = $request->post('nome');
        $edit->carga_horaria = $request->post('carga_horaria');
        $edit->professor_id = $request->post('professor_id');
        $edit->update();

        return view('cursos.index');
    }

    public function destroy($id)
    {
        $edit = Curso::find($id);
        $edit->delete();

        return view('cursos.index');
    }
}
