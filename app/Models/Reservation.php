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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }
}
