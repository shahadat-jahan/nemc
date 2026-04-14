<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PaymentType extends Model
{
    use BlamableTrait;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'payment_types';
    protected $guarded = ['id'];
    //payment Detail related to payment type
    public function paymentDetails(){

        return $this->hasMany(PaymentDetail::class, 'payment_type_id');
    }
}
