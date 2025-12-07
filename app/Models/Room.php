<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded;

    // relasi eloquent model user dengan model room
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
