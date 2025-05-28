@extends('adminlte::page')

@section('title', 'Cadastro de Cursos')

@section('content_header')
@stop

@section('content')
    <h1>Cursos</h1>

    <a href="{{ route('cursos.create') }}" class="btn btn-primary mb-3">Novo Curso</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Carga Horária</th>
                <th>Professor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
                <tr>
                    <td>{{ $curso->nome }}</td>
                    <td>{{ $curso->carga_horaria }} horas</td>
                    <td>{{ $curso->professor->name }}</td>
                    <td>
                        <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('cursos.destroy', $curso) }}" method="POST" style="display:inline;">
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
