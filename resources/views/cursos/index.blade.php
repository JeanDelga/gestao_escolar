@extends('adminlte::page')

@section('title', 'Cursos')

@section('content_header')
    <h1>Cursos</h1>
@stop

@section('content')

<a href="{{ route('cursos.create') }}" class="btn btn-primary mb-3">Novo Curso</a>

<table id="tabela" class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Carga Horária</th>
            <th>Professor Responsável</th>
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
        ajax: "{{ route('cursos.index') }}",
        columns: [
            { data: 'nome', name: 'nome' },
            { data: 'carga_horaria', name: 'carga_horaria' },
            { data: 'professor_id', name: 'professor_id' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@stop
