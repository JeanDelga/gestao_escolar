@extends('adminlte::page')

@section('title', '{{ $action }} Aluno')

@section('content_header')
    <h1>{{ $action }} Aluno</h1>
@stop

@section('content')

<form action="{{ $action == 'Editar' ? route('alunos.update', $edit->id) : route('alunos.store') }}" method="POST">
    @csrf
    @if($action == 'Editar')
        @method('PUT')
    @endif

    <div class="form-group">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" value="{{ $edit->nome ?? '' }}">
    </div>

    <div class="form-group">
        <label>Matrícula</label>
        <input type="text" name="matricula" class="form-control" value="{{ $edit->matricula ?? '' }}">
    </div>

    <div class="form-group">
        <label>Data de Nascimento</label>
        <input type="date" name="data_nascimento" class="form-control" value="{{ $edit->data_nascimento ?? '' }}">
    </div>

    <button type="submit" class="btn btn-success">{{ $action }}</button>
</form>

@stop
