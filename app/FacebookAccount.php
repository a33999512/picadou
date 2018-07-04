<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookAccount extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider', 'token'];

    public function user() {
        return $this->belongsTo('\App\User');
    }
}
