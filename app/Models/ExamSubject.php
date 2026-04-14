<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ExamSubject extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'exam_subjects';
    protected $guarded = ['id'];

    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function subjectGroup(){
        return $this->belongsTo(SubjectGroup::class, 'subject_group_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function examType(){
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }

    public function examSubTypes(){
        return $this->belongsToMany(ExamSubType::class, 'exam_subject_student_groups', 'exam_subject_id', 'exam_sub_type_id')
            ->withPivot('student_group_id', 'exam_date', 'exam_time');
    }

    public function studentGroups(){
        return $this->belongsToMany(StudentGroup::class, 'exam_subject_student_groups', 'exam_subject_id', 'student_group_id')
            ->withPivot('exam_sub_type_id', 'exam_date', 'exam_time')->orderBy('exam_subject_student_groups.exam_date');
    }

    //Change date format
    public function getExamDateAttribute($value){
        if (empty($value)) {
            return null;
        }
        return formatDate($value, 'd/m/Y');
    }

    public function setExamDateAttribute($value){
        $this->attributes['exam_date'] = !empty($value)
            ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
            : null;
    }



    public function getResultPublishDateAttribute($value){
        if (empty($value)) {
            return null;
        }
        return formatDate($value, 'd/m/Y');
    }

    public function setResultPublishDateAttribute($value){
        $this->attributes['result_publish_date'] = !empty($value)
            ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d')
            : null;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($examSubject) {
            if ($examSubject->studentGroups()->exists()) {
                $examSubject->studentGroups()->detach();
            }

            if ($examSubject->examSubTypes()->exists()) {
                $examSubject->examSubTypes()->detach();
            }

            // Optional: Delete related ExamSubType records if needed
            // $examSubject->examSubTypes()->delete();
        });
    }
}
