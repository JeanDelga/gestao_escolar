<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route("usuarios.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        <form action="' . route("usuarios.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
                            ' . csrf_field() . method_field("DELETE") . '
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2"><i class="fas fa-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('usuarios.index');
    }

    public function create()
    {
        $action = 'Criar';
        return view('usuarios.crud', compact('action'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $edit = new User();
        $edit->name = $request->post('name');
        $edit->email = $request->post('email');
        $edit->role = $request->post('role');
        $edit->password = Hash::make($request->post('password'));
        $edit->save();

        return view('usuarios.index');
    }

    public function edit($id)
    {
        $edit = User::find($id);
        $action = 'Editar';
        return view('usuarios.crud', compact('edit', 'action'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $edit = User::find($id);
        $edit->name = $request->post('name');
        $edit->email = $request->post('email');
        $edit->role = $request->post('role');

        if ($request->filled('password')) {
            $edit->password = Hash::make($request->post('password'));
        }

        $edit->update();

        return view('usuarios.index');
    }

    public function destroy($id)
    {
        $edit = User::find($id);
        $edit->delete();

        return view('usuarios.index');
    }
}
