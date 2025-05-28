@extends('adminlte::page')

@section('title', 'Vínculos Aluno-Curso')

@section('content_header')
    <h1>Vínculos Aluno-Curso</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('aluno_curso.create') }}" class="btn btn-primary mb-3">Novo Vínculo</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vinculos as $vinculo)
                <tr>
                    <td>{{ $vinculo->aluno_nome }}</td>
                    <td>{{ $vinculo->curso_nome }}</td>
                    <td>
                        <form action="{{ route('aluno_curso.destroy', $vinculo->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Deseja remover este vínculo?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
