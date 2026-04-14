<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentFeeDetail extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'student_fee_details';
    protected $guarded = ['id'];

    public function fee(){
        return $this->belongsTo(StudentFee::class, 'student_fee_id');
    }

    public function paymentType(){
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function studentPaymentDetails(){
        return $this->hasMany(StudentPaymentDetail::class, 'student_fee_detail_id');
    }

    /*public function studentPaymentsDetail(){
        return $this->hasMany(StudentPayment::class, 'student_fee_detail_id');
    }*/

    /*public function studentPayments(){
        return $this->hasMany(StudentPayment::class, 'student_fee_id');
    }*/

    public function getLastDateOfPaymentAttribute($value){
        return formatDate($value, 'd/m/Y');
    }

    public function setLastDateOfPaymentAttribute($value){
        $this->attributes['last_date_of_payment'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
}
