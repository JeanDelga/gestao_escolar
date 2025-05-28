<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alunos.crud');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();      

        $nome = $request->post('nome');
        $matricula = $request->post('matricula');
        $data_nascimento = $request->post('data_nascimento');

        $edit = new Aluno();

        $edit->nome = $nome;
        $edit->matricula = $matricula;
        $edit->data_nascimento = $data_nascimento;
        $edit->origin_user = $user->name;
        $edit->last_user = $user->name;
        $edit->save();

        return view('alunos.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $edit = Aluno::find($id);

        $output = array(
            'edit' => $edit,
        );

        return view('alunos.crud', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();      

        $nome = $request->post('nome');
        $matricula = $request->post('matricula');
        $data_nascimento = $request->post('data_nascimento');

        $edit = Aluno::find($id);

        $edit->nome = $nome;
        $edit->matricula = $matricula;
        $edit->data_nascimento = $data_nascimento;
        $edit->last_user = $user->name;
        $edit->update();

        return view('alunos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $edit = Aluno::find($id);
        $edit->delete();

        return view('alunos.index');
    }
}
