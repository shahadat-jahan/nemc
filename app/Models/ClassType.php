<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ClassType extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'class_types';
    protected $guarded = ['id'];

    public function studentGroupTypes()
    {
        return $this->belongsToMany(StudentGroupType::class, 'class_type_student_group_type', 'class_type_id', 'student_group_type_id');
    }

}
