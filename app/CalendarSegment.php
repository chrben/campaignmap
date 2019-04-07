<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarSegment extends Model
{
    protected $fillable = [
        'name', 'alt_name', 'is_holiday', 'index', 'length',
    ];

    public function calendar() {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }
}
