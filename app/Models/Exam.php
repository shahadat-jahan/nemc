<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Exam extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'exams';
    protected $guarded = ['id'];

    public function examSubjects(){
        return $this->hasMany(ExamSubject::class, 'exam_id');
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function phase(){
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function examCategory(){
        return $this->belongsTo(ExamCategory::class, 'exam_category_id');
    }

    public function examMarks(){
        return $this->hasMany(ExamSubjectMark::class, 'exam_id');
    }

    public function mainExam()
    {
        return $this->hasOne(__class__, 'id', 'main_exam_id');
    }

    public function supplementaryExam()
    {
        return $this->hasOne(__class__, 'main_exam_id', 'id');
    }
}
