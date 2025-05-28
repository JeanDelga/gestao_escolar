@extends('adminlte::page')

@section('title', 'Cadastro de Disciplinas')

@section('content_header')
@stop

@section('content')
    <h1>Disciplinas</h1>

    <a href="{{ route('disciplinas.create') }}" class="btn btn-primary mb-3">Nova Disciplina</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disciplinas as $disciplina)
                <tr>
                    <td>{{ $disciplina->nome }}</td>
                    <td>{{ $disciplina->curso->nome }}</td>
                    <td>
                        <a href="{{ route('disciplinas.edit', $disciplina) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('disciplinas.destroy', $disciplina) }}" method="POST" style="display:inline;">
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
