@extends('adminlte::page')

@section('title', isset($disciplina) ? 'Editar Disciplina' : 'Nova Disciplina')

@section('content_header')
    <h1>{{ isset($disciplina) ? 'Editar' : 'Nova' }} Disciplina</h1>
@stop

@section('content')
    <form action="{{ isset($disciplina) ? route('disciplinas.update', $disciplina->id) : route('disciplinas.store') }}" method="POST">
        @csrf
        @if(isset($disciplina))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $disciplina->nome ?? '') }}">
        </div>

        <div class="form-group">
            <label for="curso_id">Curso:</label>
            <select name="curso_id" class="form-control">
                @foreach(\App\Models\Curso::all() as $curso)
                    <option value="{{ $curso->id }}" {{ (isset($disciplina) && $disciplina->curso_id == $curso->id) ? 'selected' : '' }}>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@stop
