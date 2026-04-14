<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class TeacherEvaluation extends Model
{
    use BlamableTrait, LogsActivity, SoftDeletes;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;

    protected $guarded = ['id'];
    protected $casts = ['is_role_model' => 'boolean'];

    // RELATIONSHIP - This is the key part
    public function statementRatings()
    {
        return $this->hasMany(TeacherEvaluationStatement::class, 'teacher_evaluation_id');
    }

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
