<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::all();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        $professores = User::where('role', 'professor')->get();
        return view('cursos.create', compact('professores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'carga_horaria' => 'required|integer',
            'professor_id' => 'required|exists:users,id',
        ]);

        Curso::create($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

    public function show(Curso $curso)
    {
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $professores = User::where('role', 'professor')->get();
        return view('cursos.edit', compact('curso', 'professores'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nome' => 'required|string',
            'carga_horaria' => 'required|integer',
            'professor_id' => 'required|exists:users,id',
        ]);

        $curso->update($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso excluído com sucesso!');
    }
}
