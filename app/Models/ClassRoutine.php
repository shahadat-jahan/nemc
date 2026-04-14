<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class ClassRoutine
 * @package App\Models
 */
class ClassRoutine extends Model
{
    use BlamableTrait, SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'class_routines';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $appends = ['day_name', 'class_time'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classSession(){
        return $this->belongsTo(Session::class, 'session_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function session(){
//        return $this->belongsToMany(Session::class, 'class_routine_session_batch_types', 'class_routine_id', 'session_id')->withPivot('batch_type_id');
        return $this->belongsTo(Session::class, 'session_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function batchType(){
//        return $this->belongsToMany(BatchType::class, 'class_routine_session_batch_types', 'class_routine_id', 'batch_type_id')->withPivot('session_id');
        return $this->belongsTo(BatchType::class, 'batch_type_id');
    }

    public function studentGroup(){
        return $this->belongsToMany(StudentGroup::class, 'class_routine_student_groups', 'class_routine_id', 'student_group_id')->withPivot('teacher_id');
    }

    public function studentGroupTeacher(){
        return $this->belongsToMany(Teacher::class, 'class_routine_student_groups', 'class_routine_id', 'teacher_id')->withPivot('student_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hall(){
        return $this->belongsTo(Hall::class, 'hall_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phase(){
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic(){
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function classType(){
        return $this->belongsTo(ClassType::class, 'class_type_id');
    }

    public function attendances(){
        return $this->hasMany(Attencance::class, 'class_routine_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * @return string
     */
    public function getDayNameAttribute(){
        return (new \DateTime($this->class_date))->format('l');
    }

    /**
     * @return string
     */
    public function getClassTimeAttribute(){
        $start = new \DateTime($this->start_from);
        $end = new \DateTime($this->end_at);
        return $start->format('g:i a').' - '.$end->format('g:i a');
    }

    //lecture material related to class routine
    public function lectureMaterials(){
        return $this->hasMany(LectureMaterial::class, 'class_routine_id');
    }

    public function scopeClassAttendance($query)
    {
        $query->select([
            '*',
            \DB::raw('(SELECT COUNT(`attendance`) FROM `attencance` WHERE `class_routines`.`id` = `attencance`.`class_routine_id` AND `attencance`.`attendance` = 1) AS `present`'),
            \DB::raw('(SELECT COUNT(`attendance`) FROM `attencance` WHERE `class_routines`.`id` = `attencance`.`class_routine_id` AND `attencance`.`attendance` = 0) AS `absent`'),
        ]);

        return $query;
    }
}
