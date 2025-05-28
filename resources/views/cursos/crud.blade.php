@extends('adminlte::page')

@section('title', '{{ $action }} Curso')

@section('content_header')
    <h1>{{ $action }} Curso</h1>
@stop

@section('content')
    <form action="{{ $action == 'Editar' ? route('cursos.update', $curso->id) : route('cursos.store') }}" method="POST">
        @csrf

        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nome">Nome do Curso</label>
            <input type="text" name="nome" class="form-control" value="{{ $curso->nome ?? '' }}" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" class="form-control" required>{{ $curso->descricao ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="carga_horaria">Carga Horária</label>
            <input type="number" name="carga_horaria" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">{{ $action }}</button>
    </form>
@stop
