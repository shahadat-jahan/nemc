<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Session
 * @package App\Models
 */
class Session extends Model
{
    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    /**
     * @var string
     */
    protected $table = 'sessions';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessionDetails(){
        return $this->hasMany(SessionDetail::class, 'session_id');
    }

    public function mbbsSessionDetails(){
        return $this->hasMany(SessionDetail::class, 'session_id')->where('course_id', 1);
    }

    public function bdsSessionDetails(){
        return $this->hasMany(SessionDetail::class, 'session_id')->where('course_id', 2);
    }

    //holiday related to session
    public function holidays() {
        return $this->hasMany(Holiday::class, 'session_id');
    }

    //notice board related to session
    public function noticeBoards() {
        return $this->hasMany(NoticeBoard::class, 'session_id');
    }

    public function students(){
        return $this->hasMany(Student::class, 'session_id');
    }

    public function paymentDetails(){
        return $this->hasMany(PaymentDetail::class, 'session_id');
    }
}
