<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function users() {
        return $this->belongsToMany(User::class, 'campaign_user');
    }
}
