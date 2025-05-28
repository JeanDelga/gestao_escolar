@extends('adminlte::page')

@section('title', 'Cadastro de Alunos')

@section('content_header')
@stop

@section('content')
    <h1>Alunos</h1>

    <a href="{{ route('alunos.create') }}" class="btn btn-primary mb-3">Novo Aluno</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Matrícula</th>
                <th>Data de Nascimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alunos as $aluno)
                <tr>
                    <td>{{ $aluno->nome }}</td>
                    <td>{{ $aluno->matricula }}</td>
                    <td>{{ $aluno->data_nascimento }}</td>
                    <td>
                        <a href="{{ route('alunos.edit', $aluno) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('alunos.destroy', $aluno) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
