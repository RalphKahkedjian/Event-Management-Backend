<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable =  [
        'place',
        'time',
        'price',
        'spots',
        'organizer_id',
        'qr_code'
    ];

    public function organizers() {
        return $this->belongsTo(Organizer::class);
    }

    public function booking() {
        return $this->hasMany(Booking::class);
    }
}
