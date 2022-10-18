<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Attendee extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'event_id',
        'firstname',
        'lastname',
        'email',
        'address',
        'phone',
        'remark',
    ];

}
