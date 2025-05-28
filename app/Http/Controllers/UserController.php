<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtns = '
                        <a href="' . route("usuarios.edit", $row->id) . '" class="btn btn-outline-info btn-sm"><i class="fas fa-pen"></i></a>
                        
                        <form action="' . route("usuarios.destroy", $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Deseja realmente excluir este registro?\')">
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

        return view('usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.crud');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();      

        $name = $request->post('name');
        $email = $request->post('email');
        $role = $request->post('role');
        $password = $request->post('password');

        $edit = new User();

        $edit->name = $name;
        $edit->email = $email;
        $edit->role = $role;
        $edit->password = Hash::make($password);
        $edit->origin_user = $user->name;
        $edit->last_user = $user->name;
        $edit->save();

        return view('usuarios.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $edit = User::find($id);

        $output = array(
            'edit' => $edit
        );

        return view('usuarios.crud', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();      

        $name = $request->post('name');
        $email = $request->post('email');
        $role = $request->post('role');

        $edit = User::find($id);

        $edit->name = $name;
        $edit->email = $email;
        $edit->role = $role;
        $edit->last_user = $user->name;

        // Atualiza a senha se foi enviada
        if ($request->filled('password')) {
            $edit->password = Hash::make($request->post('password'));
        }

        $edit->update();

        return view('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $edit = User::find($id);
        $edit->delete();

        return view('usuarios.index');
    }
}
