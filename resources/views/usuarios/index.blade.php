@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')

<a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Novo Usuário</a>

<table id="tabela" class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Função</th>
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
        ajax: "{{ route('usuarios.index') }}",
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@stop
