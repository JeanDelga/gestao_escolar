@extends('adminlte::page')

@section('title', 'Cadastro de Notas')

@section('content_header')
@stop

@section('content')
    <h1>Notas</h1>

    <a href="{{ route('notas.create') }}" class="btn btn-primary mb-3">Lançar Nota</a>

    <table class="table">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Curso</th>
                <th>Disciplina</th>
                <th>Nota</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notas as $nota)
                <tr>
                    <td>{{ $nota->aluno->nome }}</td>
                    <td>{{ $nota->curso->nome }}</td>
                    <td>{{ $nota->disciplina->nome }}</td>
                    <td>{{ $nota->valor }}</td>
                    <td>
                        <a href="{{ route('notas.edit', $nota) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('notas.destroy', $nota) }}" method="POST" style="display:inline;">
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
