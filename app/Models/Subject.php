<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Subject extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'subjects';
    protected $guarded = ['id'];

    public function subjectGroup(){
        return $this->belongsTo(SubjectGroup::class, 'subject_group_id');
    }

    /*public function examCategories() {
        return $this->belongsToMany(ExamCategory::class, 'subject_exam_categories', 'subject_id','exam_category_id');
    }*/

    public function examSubTypes() {
        return $this->belongsToMany(ExamSubType::Class, 'subject_exam_sub_types','subject_id', 'exam_sub_type_id');
    }
    //department related to subject
    public function department(){
        return $this->belongsTo(Department::class);
    }

    //topic head related to subject
    public function topicHeads(){
        return $this->hasMany(TopicHead::class);
    }

    public function sessionPhase(){
        return $this->belongsToMany(SessionPhaseDetail::class, 'session_phase_detail_subjects', 'subject_id', 'session_phase_detail_id');
    }

    //book related to subject
    public function books() {
        return $this->hasMany(Book::class, 'subject_id');
    }

    public function classRoutines(){
        return $this->hasMany(ClassRoutine::class, 'subject_id');
    }
    //card related to subject
    public function cards(){
        return $this->hasMany(Card::class, 'subject_id');
    }

}
