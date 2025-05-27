<?php

namespace App\Models;

use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $table = 'disciplinas';
    protected $guarded = ['id'];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_disciplina');
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'notas')->withPivot('valor');
    }
}
