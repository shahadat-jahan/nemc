<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Student
 * @package App\Models
 */
class Student extends Model
{
    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'students';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(){
        return $this->belongsTo(Guardian::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emergencyContact(){
        return $this->hasOne(EmergencyContact::class, 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educations(){
        return $this->hasMany(EducationHistory::class, 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments(){
        return $this->hasMany(Attachment::class, 'student_id');
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id');
    }
    public function followedBySession(){
        return $this->belongsTo(Session::class, 'followed_by_session_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function studentCategory(){
        return $this->belongsTo(StudentCategory::class, 'student_category_id');
    }

    public function phase(){
        return $this->belongsTo(Phase::class, 'phase_id');
    }
    public function term(){
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendances(){
        return $this->hasMany(Attencance::class, 'student_id');
    }

    public function result(){
        return $this->hasMany(ExamResult::class, 'student_id');
    }
    public function batchType(){
        return $this->belongsTo (BatchType::class, 'batch_type_id');
    }
    public function country(){
        return $this->belongsTo(Country::class, 'nationality');
    }

    public function fee(){
        return $this->hasMany(StudentFee::class, 'student_id');
    }

    public function studentGroups(){
        return $this->belongsToMany(StudentGroup::class, 'student_group_students', 'student_id', 'student_group_id')->withPivot('student_group_id');
    }

    //change date format
    public function getFormFillupDateAttribute($value){
        if ($value != null){
            return formatDate($value, 'd/m/Y');
        }
        return '';
    }

    public function setFormFillupDateAttribute($value){
        if ($value != null){
            $this->attributes['form_fillup_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }

    public function getDateOfBirthAttribute($value){
        return formatDate($value, 'd/m/Y');
    }

    public function setDateOfBirthAttribute($value){
        $this->attributes['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getFullNameAttribute()
    {
        return $this->full_name_en;
    }

    /**
     * Get all teacher evaluations submitted by this student
     */
    public function teacherEvaluations()
    {
        return $this->hasMany(TeacherEvaluation::class, 'student_id');
    }

    public function campaigns()
    {
        return $this->morphMany(
            \App\Models\CampaignRecipient::class,
            'recipientable'
        );
    }
}
