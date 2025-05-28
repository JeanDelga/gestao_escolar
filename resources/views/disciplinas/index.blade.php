@extends('adminlte::page')

@section('title', 'Disciplinas')

@section('content_header')
    <h1>Disciplinas</h1>
@stop

@section('plugins.Datatables', true)

@section('content')
    <a href="{{ route('disciplinas.create') }}" class="btn btn-primary mb-3">Nova Disciplina</a>
    <table class="table table-bordered" id="tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>
        </thead>
    </table>
@stop

@section('plugins.Datatables', true)

@section('js')
<script>
$(function() {
    $('#tabela').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('disciplinas.index') }}',
        columns: [
            { data: 'nome', name: 'nome' },
            { data: 'curso', name: 'curso' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@stop
