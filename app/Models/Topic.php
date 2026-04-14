<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Topic extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'topics';
    protected $guarded = ['id'];

    //topic related to topic head
    public function topicHead(){
        return $this->belongsTo(TopicHead::Class, 'topic_head_id');
    }

    public function teachers(){
        return $this->belongsToMany(Teacher::Class, 'topic_teachers','topic_id', 'teacher_id');
    }

    /**
     * Get the lesson plans for the topic.
     */
    public function lessonPlans()
    {
        return $this->hasMany(LessonPlan::class);
    }
}
