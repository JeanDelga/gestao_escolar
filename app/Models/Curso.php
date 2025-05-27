<?php

namespace App\Models;

use App\Models\Aluno;
use App\Models\Disciplina;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $guarded = ['id'];

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_curso');
    }

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }
}
