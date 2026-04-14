<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ExamCategory extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'exam_categories';
    protected $guarded = ['id'];

    /*public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_exam_categories');
    }*/

    public function studentGroupTypes()
    {
        return $this->belongsToMany(StudentGroupType::class, 'exam_category_student_group_type', 'exam_category_id', 'student_group_type_id');
    }

}
