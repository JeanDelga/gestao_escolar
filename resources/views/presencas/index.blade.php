@extends('adminlte::page')

@section('title', 'Presenças')

@section('content_header')
    <h1>Presenças</h1>
@stop

@section('plugins.Datatables', true)

@section('content')

<a href="{{ route('presencas.create') }}" class="btn btn-primary mb-3">Nova Presença</a>

<table id="tabela" class="table table-bordered">
    <thead>
        <tr>
            <th>Aluno</th>
            <th>Curso</th>
            <th>Data</th>
            <th>Presente</th>
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
        ajax: "{{ route('presencas.index') }}",
        columns: [
            { data: 'aluno_id', name: 'aluno_id' },
            { data: 'curso_id', name: 'curso_id' },
            { data: 'data', name: 'data' },
            { data: 'presente', name: 'presente' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@stop
