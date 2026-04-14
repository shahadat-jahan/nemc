<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class NoticeBoard extends Model {

    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'notice_boards';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    //session related to notice board
    public function session(){
        return $this->belongsTo(Session::class);
    }

    //batch type related to notice board
    public function batchType(){
        return $this->belongsTo(BatchType::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_notice_board')->withTimestamps();
    }

    //change date format
    public function getPublishedDateAttribute($value){
        if ($value != null){
            return formatDate($value, 'd/m/Y');
        }
        return '';
    }

    public function setPublishedDateAttribute($value){
        if ($value != null){
            $this->attributes['published_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }
}
