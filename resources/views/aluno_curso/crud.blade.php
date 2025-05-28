@extends('adminlte::page')

@section('title', 'Vincular Aluno ao Curso')

@section('content_header')
    <h1>Vincular Aluno ao Curso</h1>
@stop

@section('content')
    <form action="{{ route('aluno_curso.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="aluno_id">Aluno:</label>
            <select name="aluno_id" class="form-control">
                @foreach($alunos as $aluno)
                    <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="curso_id">Curso:</label>
            <select name="curso_id" class="form-control">
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Vincular</button>
    </form>
@stop
