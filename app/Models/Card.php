<?php

namespace App\Models;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Card extends Model
{
    use BlamableTrait, SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $table = 'cards';
    protected $guarded = ['id'];

    public function cardItems(){
        return $this->hasMany(CardItem::class, 'card_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function phase(){
        return $this->belongsTo(Phase::class, 'phase_id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id');
    }
}
