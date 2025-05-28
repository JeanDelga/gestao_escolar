@extends('adminlte::page')

@section('title', 'Alunos')

@section('content_header')
    <h1>Alunos</h1>
@stop

@section('content')

<a href="{{ route('alunos.create') }}" class="btn btn-primary mb-3">Novo Aluno</a>

<table id="tabela" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Data de Nascimento</th>
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
        ajax: {
            url: "{{ route('alunos.index') }}",
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        },
        columns: [
            { data: 'nome', name: 'nome' },
            { data: 'matricula', name: 'matricula' },
            { data: 'data_nascimento', name: 'data_nascimento' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json'
        }
    });
});
</script>

@stop
