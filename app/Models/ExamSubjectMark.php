<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ExamSubjectMark extends Model
{
    use BlamableTrait, SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'exam_subject_marks';
    protected $guarded = ['id'];

    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function result(){
        return $this->hasMany(ExamResult::class, 'exam_subject_mark_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function examSubType(){
        return $this->belongsTo(ExamSubType::class, 'exam_sub_type_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($examSubjectMark) {
            if ($examSubjectMark->result()->exists()) {
                $examSubjectMark->result()->delete();
            }
        });
    }
}
