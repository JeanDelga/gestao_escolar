@extends('adminlte::page')

@section('title', 'Registrar Presenças')

@section('content_header')
    <h1>Registrar Presenças</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="formPresencas" method="POST" action="{{ route('presencas.store') }}">
        @csrf

        <div class="form-group">
            <label for="curso">Curso</label>
            <select id="curso" name="curso_id" class="form-control" required>
                <option value="">Selecione</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="data">Data</label>
            <input type="date" name="data" class="form-control" required>
        </div>

        <table class="table table-bordered d-none" id="tabela-presencas">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Presença</th>
                </tr>
            </thead>
            <tbody id="tbody-presencas"></tbody>
        </table>

        <button type="submit" class="btn btn-primary d-none" id="btn-salvar">Salvar Presenças</button>
    </form>
@stop

@section('js')
<script>
    document.getElementById('curso').addEventListener('change', function () {
        const cursoId = this.value;
        const tabela = document.getElementById('tabela-presencas');
        const tbody = document.getElementById('tbody-presencas');
        const btnSalvar = document.getElementById('btn-salvar');

        if (!cursoId) return;

        fetch(`/presencas/alunos/${cursoId}`)
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = '';
                data.forEach(aluno => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${aluno.nome}</td>
                            <td>
                                <select name="presencas[${aluno.id}]" class="form-control">
                                    <option value="1">Presente</option>
                                    <option value="0">Ausente</option>
                                </select>
                            </td>
                        </tr>
                    `;
                });

                tabela.classList.remove('d-none');
                btnSalvar.classList.remove('d-none');
            });
    });
</script>
@endsection
