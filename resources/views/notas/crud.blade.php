@extends('adminlte::page')

@section('title', 'Lançar Notas')

@section('content_header')
    <h1>Lançar Notas</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('notas.store') }}">
        @csrf

        <div class="form-group">
            <label for="curso">Curso</label>
            <select id="curso" name="curso" class="form-control">
                <option value="">Selecione</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="disciplina">Disciplina</label>
            <select id="disciplina" name="disciplina" class="form-control">
                <option value="">Selecione um curso primeiro</option>
            </select>
        </div>

        <div id="alunos-container" class="mt-4">
            <!-- Os campos de notas aparecerão aqui -->
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Notas</button>
    </form>
@stop

@section('js')
<script>
    $('#curso').on('change', function() {
        let cursoId = $(this).val();

        if (cursoId) {
            // Carregar Disciplinas
            $.get('/notas/disciplinas/' + cursoId, function(disciplinas) {
                let disciplinaSelect = $('#disciplina');
                disciplinaSelect.empty();
                disciplinaSelect.append('<option value="">Selecione</option>');
                $.each(disciplinas, function(index, disciplina) {
                    disciplinaSelect.append('<option value="' + disciplina.id + '">' + disciplina.nome + '</option>');
                });
            });

            // Carregar Alunos
            $.get('/notas/alunos/' + cursoId, function(alunos) {
                let container = $('#alunos-container');
                container.empty();

                if (alunos.length === 0) {
                    container.append('<p>Nenhum aluno matriculado neste curso.</p>');
                } else {
                    $.each(alunos, function(index, aluno) {
                        container.append(`
                            <div class="form-group">
                                <label>${aluno.nome}</label>
                                <input type="number" name="notas[${aluno.id}]" min="0" max="10" step="0.1" class="form-control">
                            </div>
                        `);
                    });
                }
            });
        } else {
            $('#disciplina').empty().append('<option value="">Selecione um curso primeiro</option>');
            $('#alunos-container').empty();
        }
    });
</script>
@stop
