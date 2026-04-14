<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Teacher extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = false;
    protected $table = 'teachers';
    protected $guarded = ['id'];
    protected $casts = [
        'share_phone' => 'boolean',
        'share_email' => 'boolean',
    ];
    protected $appends  = ['full_name'];

    //get department for teacher
    public function department() {

        return $this->belongsTo(Department::class);
    }
    //get designation for teacher
    public function designation() {

        return $this->belongsTo(Designation::class);
    }

    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function user(){
        //return $this->belongsTo(User::class, 'user_id')->where('user_group_id', 4);
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topics(){
        return $this->belongsToMany(Topic::class, 'topic_teachers','teacher_id', 'topic_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    //change date format
    public function getDobAttribute($value){
        return formatDate($value, 'd/m/Y');
    }

    public function setDobAttribute($value){
        $this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function classRoutine(){
        return $this->belongsTo(ClassRoutine::class, 'id','teacher_id');
    }

    /**
     * Get all evaluations for this teacher
     */
    public function evaluations()
    {
        return $this->hasMany(TeacherEvaluation::class, 'teacher_id');
    }


    /**
     * Get role model percentage
     */
    public function getRoleModelPercentage()
    {
        $total = $this->evaluations()->whereNotNull('is_role_model')->count();

        if ($total == 0) {
            return null;
        }

        $yesCount = $this->evaluations()->where('is_role_model', true)->count();

        return round(($yesCount / $total) * 100, 2);
    }

    /**
     * Get average rating across all evaluations
     */
    public function getAverageRating()
    {
        $average = $this->evaluations()->with('statementRatings')->get()->flatMap(function ($evaluation) {
            return $evaluation->statementRatings;
        })->avg('rating');

        return round($average, 2);
    }

    public function campaigns()
    {
        return $this->morphMany(
            \App\Models\CampaignRecipient::class,
            'recipientable'
        );
    }
}
