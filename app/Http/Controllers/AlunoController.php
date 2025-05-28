<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Aluno::latest()->get();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtns = '
                        <a href="' . route("alunos.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>

                        <form action="' . route("alunos.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('alunos.index');
    }


    public function create()
    {
        $action = 'Criar';
        $edit = new Aluno();
        return view('alunos.crud', compact('action'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'required|string|unique:alunos',
            'data_nascimento' => 'required|date',
        ]);

        $user = Auth::user();

        $aluno = new Aluno();
        $aluno->nome = $request->post('nome');
        $aluno->matricula = $request->post('matricula');
        $aluno->data_nascimento = $request->post('data_nascimento');
        $aluno->origin_user = $user->name ?? 'admin';
        $aluno->last_user = $user->name ?? 'admin';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $edit = Aluno::findOrFail($id);
        $action = 'Editar';

        return view('alunos.crud', compact('edit', 'action'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'required|string|unique:alunos,matricula,' . $id,
            'data_nascimento' => 'required|date',
        ]);

        $user = Auth::user();

        $aluno = Aluno::findOrFail($id);
        $aluno->nome = $request->post('nome');
        $aluno->matricula = $request->post('matricula');
        $aluno->data_nascimento = $request->post('data_nascimento');
        $aluno->last_user = $user->name ?? 'admin';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->delete();

        return redirect()->route('alunos.index')->with('success', 'Aluno excluído com sucesso!');
    }
}
