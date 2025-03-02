<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'distribution_id',
        'start_date',
        'end_date',
        'status',
        'notes',
        'answer',
    ];

    protected function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function room()
    {
        return $this->belongsTo(Room::class);
    }

    protected function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }
}
