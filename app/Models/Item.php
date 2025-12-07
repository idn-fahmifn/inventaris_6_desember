<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded;

    // relasi eloquent model user dengan model room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
