<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CursoController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {

        if (auth()->user()->role == 'admin') {
            // Admin vê todos
            $data = Curso::latest()->get();
        } else {
            // Professores veem só os deles
            $data = Curso::where('professor_id', auth()->id())->latest()->get();
        }

        return DataTables::of($data)
            ->addColumn('action', function($row){
                $actionBtns = '
                    <a href="'.route("cursos.edit", $row->id).'" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                    <form action="'.route("cursos.destroy", $row->id).'" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja excluir?\')">
                        '.csrf_field().'
                        '.method_field("DELETE").'
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


    public function create()
    {
        return view('cursos.crud', ['action' => 'Cadastrar', 'curso' => new Curso()]);
    }

    public function store(Request $request)
    {
        $curso = new Curso();
        $curso->nome = $request->nome;
        $curso->descricao = $request->descricao;
        $curso->carga_horaria = $request->carga_horaria;
        $curso->professor_id = auth()->id();
        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

    public function edit(Curso $curso)
    {
        return view('cursos.crud', ['action' => 'Editar', 'curso' => $curso]);
    }

    public function update(Request $request, Curso $curso)
    {
        $curso->nome = $request->nome;
        $curso->descricao = $request->descricao;
        $curso->carga_horaria = $request->carga_horaria;
        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso excluído com sucesso!');
    }
}
