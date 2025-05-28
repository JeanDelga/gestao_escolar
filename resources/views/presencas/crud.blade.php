@extends('adminlte::page')

@section('title', 'Cadastro de Presenças')

@section('content_header')
@stop

@section('content')
    <h1>{{ $action }} Presença</h1>

    <form action="{{ $action == 'Editar' ? route('presencas.update', $presenca) : route('presencas.store') }}" method="POST">
        @csrf
        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Aluno</label>
            <select name="aluno_id" class="form-control">
                @foreach($alunos as $aluno)
                    <option value="{{ $aluno->id }}" 
                        @if(isset($presenca) && $presenca->aluno_id == $aluno->id) selected @endif>
                        {{ $aluno->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Curso</label>
            <select name="curso_id" class="form-control">
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" 
                        @if(isset($presenca) && $presenca->curso_id == $curso->id) selected @endif>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Data</label>
            <input type="date" name="data" value="{{ $presenca->data ?? old('data') }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Presente</label>
            <select name="presente" class="form-control">
                <option value="1" @if(isset($presenca) && $presenca->presente) selected @endif>Sim</option>
                <option value="0" @if(isset($presenca) && !$presenca->presente) selected @endif>Não</option>
            </select>
        </div>

        <button class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection
