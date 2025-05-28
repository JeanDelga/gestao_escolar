@extends('adminlte::page')

@section('title', 'Disciplinas')

@section('content_header')
    <h1>Disciplinas</h1>
@stop

@section('content')

<a href="{{ route('disciplinas.create') }}" class="btn btn-primary mb-3">Nova Disciplina</a>

<table id="tabela" class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Curso</th>
            <th>Ações</th>
        </tr>
    </thead>
</table>

@stop

@section('js')
<script>
$(document).ready(function() {
    $('#tabela').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('disciplinas.index') }}",
        columns: [
            { data: 'nome', name: 'nome' },
            { data: 'curso_id', name: 'curso_id' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@stop
