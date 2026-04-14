<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class StudentFee
 * @package App\Models
 */
class StudentFee extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    /**
     * @var string
     */
    protected $table = 'student_fees';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeDetails(){
        return $this->hasMany(StudentFeeDetail::class, 'student_fee_id');
    }

    /*public function studentPayments(){
        return $this->hasMany(StudentPayment::class, 'student_fee_id');
    }*/

    public function studentPaymentDetails(){
        return $this->hasMany(StudentPaymentDetail::class, 'student_fee_id');
    }
}
