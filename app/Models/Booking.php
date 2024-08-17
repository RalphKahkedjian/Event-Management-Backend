<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'attendee_id',
        'spots',
        'status'
    ];

    public function attendee() {
        return $this->belongsTo(Attendee::class);
    }

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
}
