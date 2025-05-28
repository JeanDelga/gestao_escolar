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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Presenca::latest()->get();
            
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtns = '
                        <a href="' . route("presencas.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        
                        <form action="' . route("presencas.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
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

        return view('presencas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();

        return view('presencas.crud', compact('alunos', 'cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();      

        $aluno_id = $request->post('aluno_id');
        $curso_id = $request->post('curso_id');
        $data = $request->post('data');
        $presente = $request->post('presente');

        $edit = new Presenca();

        $edit->aluno_id = $aluno_id;
        $edit->curso_id = $curso_id;
        $edit->data = $data;
        $edit->presente = $presente;
        $edit->origin_user = $user->name;
        $edit->last_user = $user->name;
        $edit->save();

        return view('presencas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $edit = Presenca::find($id);
        $alunos = Aluno::all();
        $cursos = Curso::all();

        $output = array(
            'edit' => $edit,
            'alunos' => $alunos,
            'cursos' => $cursos
        );

        return view('presencas.crud', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();      

        $aluno_id = $request->post('aluno_id');
        $curso_id = $request->post('curso_id');
        $data = $request->post('data');
        $presente = $request->post('presente');

        $edit = Presenca::find($id);

        $edit->aluno_id = $aluno_id;
        $edit->curso_id = $curso_id;
        $edit->data = $data;
        $edit->presente = $presente;
        $edit->last_user = $user->name;
        $edit->update();

        return view('presencas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $edit = Presenca::find($id);
        $edit->delete();

        return view('presencas.index');
    }
}
