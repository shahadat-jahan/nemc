<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TopicHead extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'topic_heads';
    protected $guarded = ['id'];

    //subject related to topic head
    public function subject() {

        return $this->belongsTo(Subject::class, 'subject_id');

    }

    //topic head related to topic
    public function topics() {

        return $this->hasMany(Topic::class);
    }
}
