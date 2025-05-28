<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DisciplinaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Disciplina::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route("disciplinas.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        <form action="' . route("disciplinas.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('disciplinas.index');
    }

    public function create()
    {
        $action = 'Criar';
        $cursos = Curso::all();
        return view('disciplinas.crud', compact('action', 'cursos'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $edit = new Disciplina();
        $edit->nome = $request->post('nome');
        $edit->curso_id = $request->post('curso_id');
        $edit->save();

        return view('disciplinas.index');
    }

    public function edit($id)
    {
        $edit = Disciplina::find($id);
        $action = 'Editar';
        $cursos = Curso::all();
        return view('disciplinas.crud', compact('edit', 'action', 'cursos'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $edit = Disciplina::find($id);
        $edit->nome = $request->post('nome');
        $edit->curso_id = $request->post('curso_id');
        $edit->update();

        return view('disciplinas.index');
    }

    public function destroy($id)
    {
        $edit = Disciplina::find($id);
        $edit->delete();

        return view('disciplinas.index');
    }
}
