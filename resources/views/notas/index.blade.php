@extends('adminlte::page')

@section('title', 'Notas')

@section('content_header')
    <h1>Notas</h1>
@stop

@section('content')

<a href="{{ route('notas.create') }}" class="btn btn-primary mb-3">Nova Nota</a>

<table id="tabela" class="table table-bordered">
    <thead>
        <tr>
            <th>Aluno</th>
            <th>Curso</th>
            <th>Disciplina</th>
            <th>Nota</th>
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
        ajax: "{{ route('notas.index') }}",
        columns: [
            { data: 'aluno_id', name: 'aluno_id' },
            { data: 'curso_id', name: 'curso_id' },
            { data: 'disciplina_id', name: 'disciplina_id' },
            { data: 'valor', name: 'valor' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@stop
