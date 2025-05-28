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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Nota::latest()->get();
            
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtns = '
                        <a href="' . route("notas.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        
                        <form action="' . route("notas.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
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

        return view('notas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alunos = Aluno::all();
        $cursos = Curso::all();
        $disciplinas = Disciplina::all();

        return view('notas.crud', compact('alunos', 'cursos', 'disciplinas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();      

        $aluno_id = $request->post('aluno_id');
        $curso_id = $request->post('curso_id');
        $disciplina_id = $request->post('disciplina_id');
        $valor = $request->post('valor');

        $edit = new Nota();

        $edit->aluno_id = $aluno_id;
        $edit->curso_id = $curso_id;
        $edit->disciplina_id = $disciplina_id;
        $edit->valor = $valor;
        $edit->origin_user = $user->name;
        $edit->last_user = $user->name;
        $edit->save();

        return view('notas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $edit = Nota::find($id);
        $alunos = Aluno::all();
        $cursos = Curso::all();
        $disciplinas = Disciplina::all();

        $output = array(
            'edit' => $edit,
            'alunos' => $alunos,
            'cursos' => $cursos,
            'disciplinas' => $disciplinas
        );

        return view('notas.crud', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();      

        $aluno_id = $request->post('aluno_id');
        $curso_id = $request->post('curso_id');
        $disciplina_id = $request->post('disciplina_id');
        $valor = $request->post('valor');

        $edit = Nota::find($id);

        $edit->aluno_id = $aluno_id;
        $edit->curso_id = $curso_id;
        $edit->disciplina_id = $disciplina_id;
        $edit->valor = $valor;
        $edit->last_user = $user->name;
        $edit->update();

        return view('notas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $edit = Nota::find($id);
        $edit->delete();

        return view('notas.index');
    }
}
