<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Course extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'courses';
    protected $guarded = ['id'];

    public function subjectGroups()
    {
        return $this->hasMany(SubjectGroup::class);
    }
    //payment detail related to course
    public function paymentDetails() {
        return $this->hasMany(PaymentDetail::class, 'course_id');
    }
    public function teachers(){
        return $this->hasMany(Teacher::class, 'course_id');
    }

    public function students(){
        return $this->hasMany(Student::class, 'course_id');
    }
}
