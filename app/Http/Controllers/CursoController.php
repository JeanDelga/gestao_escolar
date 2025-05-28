<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Curso::latest()->get();
            
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtns = '
                        <a href="' . route("cursos.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        
                        <form action="' . route("cursos.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
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

        return view('cursos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professores = User::where('role', 'professor')->get();

        return view('cursos.crud', compact('professores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();      

        $nome = $request->post('nome');
        $carga_horaria = $request->post('carga_horaria');
        $professor_id = $request->post('professor_id');

        $edit = new Curso();

        $edit->nome = $nome;
        $edit->carga_horaria = $carga_horaria;
        $edit->professor_id = $professor_id;
        $edit->origin_user = $user->name;
        $edit->last_user = $user->name;
        $edit->save();

        return view('cursos.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $edit = Curso::find($id);
        $professores = User::where('role', 'professor')->get();

        $output = array(
            'edit' => $edit,
            'professores' => $professores
        );

        return view('cursos.crud', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();      

        $nome = $request->post('nome');
        $carga_horaria = $request->post('carga_horaria');
        $professor_id = $request->post('professor_id');

        $edit = Curso::find($id);

        $edit->nome = $nome;
        $edit->carga_horaria = $carga_horaria;
        $edit->professor_id = $professor_id;
        $edit->last_user = $user->name;
        $edit->update();

        return view('cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $edit = Curso::find($id);
        $edit->delete();

        return view('cursos.index');
    }
}
