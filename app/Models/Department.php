<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'departments';
    protected $guarded = ['id'];

    //subject related to department
    public function subjects(){
        return $this->hasMany(Subject::class);
    }

    //get teachers for department
    public function teachers(){
        return $this->hasMany(Teacher::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'department_lead_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'department_lead_id');
    }

    public function studentGroup(){
        return $this->hasMany(StudentGroup::class, 'department_id');
    }

    public function notice()
    {
        return $this->hasMany(NoticeBoard::class, 'department_id');
    }
}
