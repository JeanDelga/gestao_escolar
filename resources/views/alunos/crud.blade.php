@extends('adminlte::page')

@section('title', 'Cadastro de Alunos')

@section('content_header')
@stop

@section('content')
    <h1>{{ $action }} Aluno</h1>

    <form action="{{ $action == 'Editar' ? route('alunos.update', $aluno) : route('alunos.store') }}" method="POST">
        @csrf
        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" value="{{ $aluno->nome ?? old('nome') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Matrícula</label>
            <input type="text" name="matricula" value="{{ $aluno->matricula ?? old('matricula') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nascimento" value="{{ $aluno->data_nascimento ?? old('data_nascimento') }}" class="form-control">
        </div>

        <button class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection
