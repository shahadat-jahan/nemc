<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AdvanceAmountUseHistories extends Model
{
    use BlamableTrait;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'advance_amount_use_histories';
    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function fromPaymentType()
    {
        return $this->belongsTo(PaymentType::class, 'from_payment_type_id');
    }

    public function toPaymentType()
    {
        return $this->belongsTo(PaymentType::class, 'to_payment_type_id');
    }

    public function feeDetail()
    {
        return $this->belongsTo(StudentFeeDetail::class, 'student_fee_detail_id');
    }
}
