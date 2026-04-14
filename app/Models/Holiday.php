<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Holiday extends Model {

    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'holidays';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    //session related to holiday
    public function session(){

        return $this->belongsTo(Session::class);
    }

    //batch type related to holiday
    public function batchType(){

        return $this->belongsTo(BatchType::class);
    }

    //Change date format
    public function getFromDateAttribute($value){
        return formatDate($value, 'd/m/Y');
    }

    public function setFromDateAttribute($value){
        $this->attributes['from_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getToDateAttribute($value){
        if ($value != null){
            return formatDate($value, 'd/m/Y');
        }
        return '';
    }

    public function setToDateAttribute($value){
        if ($value != null){
            $this->attributes['to_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }


}
