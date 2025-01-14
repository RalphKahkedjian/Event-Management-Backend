<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'wallet',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function booking() {
        return $this->hasMany(Booking::class);
    }
}
