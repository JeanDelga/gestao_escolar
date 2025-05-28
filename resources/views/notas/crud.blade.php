@extends('adminlte::page')

@section('title', 'Cadastro de Notas')

@section('content_header')
@stop

@section('content')
    <h1>{{ $action }} Nota</h1>

    <form action="{{ $action == 'Editar' ? route('notas.update', $nota) : route('notas.store') }}" method="POST">
        @csrf
        @if($action == 'Editar')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Aluno</label>
            <select name="aluno_id" class="form-control">
                @foreach($alunos as $aluno)
                    <option value="{{ $aluno->id }}" 
                        @if(isset($nota) && $nota->aluno_id == $aluno->id) selected @endif>
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
                        @if(isset($nota) && $nota->curso_id == $curso->id) selected @endif>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Disciplina</label>
            <select name="disciplina_id" class="form-control">
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}" 
                        @if(isset($nota) && $nota->disciplina_id == $disciplina->id) selected @endif>
                        {{ $disciplina->nome }}
                    </option>
                @endforeach
            </select>
        <div id="alunos-container"></div>

        </div>

        <div class="form-group">
            <label>Nota</label>
            <input type="number" step="0.01" name="valor" value="{{ $nota->valor ?? old('valor') }}" class="form-control">
        </div>

        <button class="btn btn-success mt-2">Salvar</button>
    </form>
@endsection
