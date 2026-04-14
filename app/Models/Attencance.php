<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Attencance extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'attencance';
    protected $guarded = ['id'];
    protected $casts = [
        'attendance' => 'boolean'
    ];

    protected $appends = ['attendance_status'];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function smsEmailLog(){
        return $this->hasMany(SmsEmailLog::class, 'attendance_id');
    }

    public function getAttendanceStatusAttribute(){

        if ($this->attendance == 1) {
            $status = '<span class="m-badge m-badge--success">Present</span>';
        } else {
            $status = '<span class="m-badge m-badge--danger">Absent</span>';
        }

        return $status;
    }

    public function classRoutine(){
        return $this->belongsTo(ClassRoutine::class, 'class_routine_id');
    }
}
