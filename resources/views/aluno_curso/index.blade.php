@extends('adminlte::page')

@section('title', 'Alunos e Cursos')

@section('content_header')
    <h1>Alunos e Cursos</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('aluno_curso.create') }}" class="btn btn-primary mb-3">Novo Vínculo</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Cursos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alunos as $aluno)
                <tr>
                    <td>{{ $aluno->nome }}</td>
                    <td>
                        @foreach($aluno->cursos as $curso)
                            <span class="badge badge-info">{{ $curso->nome }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($aluno->cursos as $curso)
                            <form action="{{ route('aluno_curso.destroy', $curso->pivot->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Remover</button>
                            </form>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
