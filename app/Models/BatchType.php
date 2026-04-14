<?php

namespace  App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BatchType extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'batch_types';
    protected $guarded = ['id'];

    //holiday related to batch type
    public function holidays() {
        return $this->hasMany(Holiday::class, 'batch_type_id');
    }
    //notice board related to batch type
    public function noticeBoards() {
        return $this->hasMany(NoticeBoard::class, 'batch_type_id');
    }
}
