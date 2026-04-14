<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class LessonPlan extends Model
{
    use BlamableTrait, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'lesson_plans';
    protected $guarded = ['id'];

    /**
     * Get the topic that owns the lesson plan.
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Get the user that created the lesson plan.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that last updated the lesson plan.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function speaker()
    {
        return $this->belongsTo(Teacher::class, 'speaker_id');
    }
}
