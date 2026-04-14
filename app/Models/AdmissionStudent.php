<?php

namespace App\Models;

use App\Services\UtilityServices;
use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AdmissionStudent extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'admission_students';
    protected $guarded = ['id'];

    public function admissionParent(){
        return $this->belongsTo(AdmissionParent::class, 'admission_parent_id');
    }

    public function admissionEmergencyContact(){
        return $this->hasOne(AdmissionEmergencyContact::class, 'admission_student_id');
    }

    public function admissionEducationHistories(){
        return $this->hasMany(AdmissionEducationHistory::class, 'admission_student_id');
    }

    public function admissionAttachments(){
        return $this->hasMany(AdmissionAttachment::class, 'admission_student_id');
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function studentCategory(){
        return $this->belongsTo(StudentCategory::class, 'student_category_id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'nationality');
    }

    //change date format
    public function getFormFillupDateAttribute($value){
        return formatDate($value, 'd/m/Y');
    }

    public function setFormFillupDateAttribute($value){
        $this->attributes['form_fillup_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDateOfBirthAttribute($value){
        return formatDate($value, 'd/m/Y');
    }

    public function setDateOfBirthAttribute($value){
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

}
