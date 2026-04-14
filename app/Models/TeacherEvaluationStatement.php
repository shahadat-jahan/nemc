<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherEvaluationStatement extends Model
{
    protected $fillable = ['teacher_evaluation_id', 'statement_id', 'rating'];

    protected $casts = [
        'statement_id' => 'integer',
        'rating'       => 'integer',
    ];

    public function evaluation()
    {
        return $this->belongsTo(TeacherEvaluation::class, 'teacher_evaluation_id');
    }
}
