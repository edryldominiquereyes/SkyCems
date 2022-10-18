<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orgrecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'date',
        'description',
    ];
    
}

