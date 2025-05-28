@extends('adminlte::page')

@section('title', 'Cadastro de Usuários')

@section('content_header')
@stop

@section('content')
    <h1>{{ $action }} Usuário</h1>

    <form action="{{ $action == 'Editar' ? route('usuarios.update', $usuario) : route('usuarios.store') }}" method="POST">
        @csrf
        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" value="{{ $usuario->name ?? old('name') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" value="{{ $usuario->email ?? old('email') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Função</label>
            <select name="role" class="form-control">
                <option value="admin" @if(isset($usuario) && $usuario->role == 'admin') selected @endif>Administrador</option>
                <option value="professor" @if(isset($usuario) && $usuario->role == 'professor') selected @endif>Professor</option>
            </select>
        </div>

        @if($action == 'Criar')
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        @endif

        <button class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection
