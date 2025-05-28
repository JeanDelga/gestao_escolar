@extends('adminlte::page')

@section('title', 'Cadastro de Disciplinas')

@section('content_header')
@stop

@section('content')
    <h1>{{ $action }} Disciplina</h1>

    <form action="{{ $action == 'Editar' ? route('disciplinas.update', $disciplina) : route('disciplinas.store') }}" method="POST">
        @csrf
        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" value="{{ $disciplina->nome ?? old('nome') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Curso</label>
            <select name="curso_id" class="form-control">
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" 
                        @if(isset($disciplina) && $disciplina->curso_id == $curso->id) selected @endif>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection
