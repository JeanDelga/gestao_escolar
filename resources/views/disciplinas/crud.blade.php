@extends('adminlte::page')

@section('title', '{{ $action }} Disciplina')

@section('content_header')
    <h1>{{ $action }} Disciplina</h1>
@stop

@section('content')
    <form action="{{ $action == 'Editar' ? route('disciplinas.update', $disciplina->id) : route('disciplinas.store') }}" method="POST">
        @csrf

        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nome">Nome da Disciplina</label>
            <input type="text" name="nome" class="form-control" value="{{ $disciplina->nome ?? '' }}" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" class="form-control" required>{{ $disciplina->descricao ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="curso_id">Curso</label>
            <select name="curso_id" class="form-control" required>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" @if(isset($disciplina) && $disciplina->curso_id == $curso->id) selected @endif>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ $action }}</button>
    </form>
@stop
