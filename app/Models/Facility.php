<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Facility extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'facility_management';

    protected $primaryKey = 'facility_id';

    protected $fillable = [
        'user_id',
        'facility',
        'description',
        'address',
        'lat',
        'lng',
        'itemList',
        'capacity',
        'image',
    ];
}
