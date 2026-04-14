<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentPaymentDetail extends Model
{
    use SoftDeletes, BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'student_payment_details';
    protected $guarded = ['id'];

    public function studentPayment(){
        return $this->belongsTo(StudentPayment::class, 'student_payment_id');
    }

    public function studentFee(){
        return $this->belongsTo(StudentFee::class, 'student_fee_id');
    }

    public function studentFeeDetail(){
        return $this->belongsTo(StudentFeeDetail::class, 'student_fee_detail_id');
    }
}
