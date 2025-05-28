<?php

namespace App\Models;

use App\Models\Nota;
use App\Models\Curso;
use App\Models\Presenca;
use App\Models\Disciplina;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'alunos';
    protected $guarded = ['id'];

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
    public function presencas()
    {
        return $this->hasMany(Presenca::class);
    }
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'aluno_curso');
    }
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'aluno_disciplina');
    }
}
