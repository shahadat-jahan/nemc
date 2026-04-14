<?php

namespace App\Models;

use App\Models\Student;
use App\Models\StudentFee;
use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentPayment extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'student_payments';
    protected $guarded = ['id'];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function studentPaymentDetails(){
        return $this->hasMany(StudentPaymentDetail::class, 'student_payment_id');
    }

    public function paymentType(){
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    //change date format
    public function getPaymentDateAttribute($value){
        return formatDate($value, 'd/m/Y');
    }

    public function setPaymentDateAttribute($value){
        $this->attributes['payment_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
