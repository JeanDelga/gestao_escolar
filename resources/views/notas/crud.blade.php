@extends('adminlte::page')

@section('title', 'Lançar Notas')

@section('content_header')
    <h1>Lançar Notas</h1>
@stop

@section('content')
    <form action="{{ route('notas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="curso">Curso</label>
            <select name="curso" id="curso" class="form-control" required>
                <option value="">Selecione um curso</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ old('curso') == $curso->id ? 'selected' : '' }}>{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="disciplina">Disciplina</label>
            <select name="disciplina" id="disciplina" class="form-control" required>
                <option value="">Selecione uma disciplina</option>
                {{-- opções serão carregadas via JS --}}
            </select>
        </div>

        <table class="table table-bordered mt-4" id="tabela-notas">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                {{-- linhas serão carregadas via JS --}}
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary mt-3">Salvar Notas</button>
    </form>
@stop

@section('js')
<script>
    document.getElementById('curso').addEventListener('change', function () {
        const cursoId = this.value;
        const disciplinaSelect = document.getElementById('disciplina');
        const tabelaBody = document.querySelector('#tabela-notas tbody');

        disciplinaSelect.innerHTML = '<option value="">Carregando...</option>';
        tabelaBody.innerHTML = '';

        fetch(`/notas/disciplinas/${cursoId}`)
            .then(res => res.json())
            .then(data => {
                disciplinaSelect.innerHTML = '<option value="">Selecione uma disciplina</option>';
                data.forEach(d => {
                    disciplinaSelect.innerHTML += `<option value="${d.id}">${d.nome}</option>`;
                });
            });
    });

    document.getElementById('disciplina').addEventListener('change', function () {
        const cursoId = document.getElementById('curso').value;
        const disciplinaId = this.value;
        const tabelaBody = document.querySelector('#tabela-notas tbody');

        tabelaBody.innerHTML = '<tr><td colspan="2">Carregando alunos...</td></tr>';

        fetch(`/notas/alunos/${cursoId}`)
            .then(res => res.json())
            .then(data => {
                tabelaBody.innerHTML = '';
                data.forEach(aluno => {
                    tabelaBody.innerHTML += `
                        <tr>
                            <td>${aluno.nome}</td>
                            <td>
                                <input type="hidden" name="notas[${aluno.id}][aluno_id]" value="${aluno.id}">
                                <input type="number" name="notas[${aluno.id}][valor]" step="0.01" min="0" max="10" class="form-control" required>
                            </td>
                        </tr>
                    `;
                });
            });
    });
</script>
@stop
