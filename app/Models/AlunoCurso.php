<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoCurso extends Model
{
    use HasFactory;

    protected $table = 'aluno_curso';
    protected $guarded = ['id'];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
