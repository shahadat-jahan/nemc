<?php

namespace App\Models;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class StudentGroup
 * @package App\Models
 */
class StudentGroup extends Model
{
    use BlamableTrait, SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'student_groups';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(){
        return $this->belongsToMany(Student::class, 'student_group_students', 'student_group_id', 'student_id')->withPivot('is_old');
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function phase(){
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function studentGroupType()
    {
        return $this->belongsTo(StudentGroupType::class, 'type', 'id');
    }

    public function oldStudents()
    {
        return $this->students()->wherePivot('is_old',1);
    }
}
