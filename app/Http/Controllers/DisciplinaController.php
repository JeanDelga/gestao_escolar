<?php


namespace App\Http\Controllers;

use App\Models\Disciplina;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DisciplinaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Disciplina::with('curso')->get();
            return DataTables::of($data)
                ->addColumn('curso', function ($row) {
                    return $row->curso->nome ?? 'Sem curso';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route("disciplinas.edit", $row->id).'" class="btn btn-info btn-sm">Editar</a>
                        <form action="'.route("disciplinas.destroy", $row->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('disciplinas.index');
    }

    public function create()
    {
        return view('disciplinas.crud');
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required', 'curso_id' => 'required']);
        Disciplina::create($request->all());
        return redirect()->route('disciplinas.index')->with('success', 'Disciplina criada com sucesso!');
    }

    public function edit($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        return view('disciplinas.crud', compact('disciplina'));
    }

    public function update(Request $request, $id)
    {
        $disciplina = Disciplina::findOrFail($id);
        $disciplina->update($request->all());
        return redirect()->route('disciplinas.index')->with('success', 'Disciplina atualizada com sucesso!');
    }

    public function destroy($id)
    {
        Disciplina::destroy($id);
        return redirect()->route('disciplinas.index')->with('success', 'Disciplina excluída com sucesso!');
    }
}
