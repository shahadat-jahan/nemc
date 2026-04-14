<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ExamSubType extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'exam_sub_types';
    protected $guarded = ['id'];

    public function examType()
    {
        return $this->belongsTo('App\Models\ExamType');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_exam_sub_types');
    }

    public function examSubjectMark(){
        return $this->hasMany(ExamSubjectMark::class, 'exam_sub_type_id');
    }
}
