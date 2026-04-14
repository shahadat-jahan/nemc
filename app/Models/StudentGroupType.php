<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentGroupType extends Model
{
    use BlamableTrait;
    use SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'student_group_types';
    protected $guarded = ['id'];


    public function studentGroups()
    {
        return $this->hasMany(StudentGroup::class, 'type', 'id');
    }

    public function classTypes()
    {
        return $this->belongsToMany(ClassType::class, 'class_type_student_group_type', 'student_group_type_id', 'class_type_id');
    }

    public function examCategories()
    {
        return $this->belongsToMany(ExamCategory::class, 'exam_category_student_group_type', 'student_group_type_id', 'exam_category_id');
    }

}
