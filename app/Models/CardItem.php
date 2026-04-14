<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CardItem extends Model
{
    use BlamableTrait, SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'card_items';
    protected $guarded = ['id'];

    public function card(){
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function examSubjects(){
        return $this->hasMany(ExamSubject::class, 'card_item_id');
    }
}
