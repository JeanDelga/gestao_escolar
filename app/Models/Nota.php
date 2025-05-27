<?php

namespace App\Models;

use App\Models\Aluno;
use App\Models\Disciplina;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'notas';
    protected $guarded = ['id'];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}
