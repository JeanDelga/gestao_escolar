@extends('adminlte::page')

@section('title', 'Cadastro de Presenças')

@section('content_header')
@stop

@section('content')
    <h1>Presenças</h1>

    <a href="{{ route('presencas.create') }}" class="btn btn-primary mb-3">Registrar Presença</a>

    <table class="table">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Curso</th>
                <th>Data</th>
                <th>Presente</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presencas as $presenca)
                <tr>
                    <td>{{ $presenca->aluno->nome }}</td>
                    <td>{{ $presenca->curso->nome }}</td>
                    <td>{{ $presenca->data }}</td>
                    <td>{{ $presenca->presente ? 'Sim' : 'Não' }}</td>
                    <td>
                        <a href="{{ route('presencas.edit', $presenca) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('presencas.destroy', $presenca) }}" method="POST" style="display:inline;">
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
