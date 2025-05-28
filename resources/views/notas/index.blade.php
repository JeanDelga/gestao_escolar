@extends('adminlte::page')

@section('title', 'Lançar Notas')

@section('content_header')
    <h1>Lançar Notas</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('notas.salvar') }}">
        @csrf

        <div class="form-group">
            <label>Curso</label>
            <select id="curso" name="curso_id" class="form-control" required>
                <option value="">Selecione</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Disciplina</label>
            <select id="disciplina" name="disciplina_id" class="form-control" required>
                <option value="">Selecione o curso primeiro</option>
            </select>
        </div>

        <div id="alunos-section" style="display: none;">
            <h4>Notas dos Alunos</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody id="alunos-tabela">
                    <!-- preenchido via JS -->
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Salvar Notas</button>
        </div>
    </form>
@stop

@section('plugins.Select2', true)

@section('js')
<script>
    $('#curso').on('change', function() {
    var cursoId = $(this).val();

    // Carrega disciplinas
    $.get('/notas/disciplinas/' + cursoId, function(data) {
        let disciplinaSelect = $('#disciplina');
        disciplinaSelect.empty();
        $.each(data, function(index, disciplina) {
            disciplinaSelect.append('<option value="' + disciplina.id + '">' + disciplina.nome + '</option>');
        });
    });

    // Carrega alunos
    $.get('/notas/alunos/' + cursoId, function(data) {
        let container = $('#alunos-container');
        container.empty();

        $.each(data, function(index, aluno) {
            container.append(`
                <div>
                    <label>${aluno.nome}</label>
                    <input type="number" name="notas[${aluno.id}]" min="0" max="10" step="0.1">
                </div>
            `);
        });
    });
});

</script>
@stop
