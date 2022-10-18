<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Eventregister extends Model
{
    use HasFactory, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'event_register_detail';

    protected $primaryKey = 'event_id';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'facility_id',
        'organizer',
        'borrow',
        'contact',
        'reason',
        'remark',
        'start_datetime',
        'end_datetime',
        'status',
    ];
    
}
