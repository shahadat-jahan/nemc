<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ExamResult extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'exam_results';
    protected $guarded = ['id'];

    public function examSubjectMark(){
        return $this->belongsTo(ExamSubjectMark::class, 'exam_subject_mark_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    //Change date format
    public function getResultDateAttribute($value){
        if ($value != null) {
            return formatDate($value, 'd/m/Y');
        }
    }

    public function setResultDateAttribute($value){
        if ($value != null) {
            $this->attributes['result_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }

}
