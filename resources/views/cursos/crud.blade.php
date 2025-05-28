@extends('adminlte::page')

@section('title', 'Cadastro de Cursos')

@section('content_header')
@stop

@section('content')
    <h1>{{ $action }} Curso</h1>

    <form action="{{ $action == 'Editar' ? route('cursos.update', $curso) : route('cursos.store') }}" method="POST">
        @csrf
        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" value="{{ $curso->nome ?? old('nome') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Carga Horária</label>
            <input type="number" name="carga_horaria" value="{{ $curso->carga_horaria ?? old('carga_horaria') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Professor</label>
            <select name="professor_id" class="form-control">
                @foreach($professores as $professor)
                    <option value="{{ $professor->id }}" 
                        @if(isset($curso) && $curso->professor_id == $professor->id) selected @endif>
                        {{ $professor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection
