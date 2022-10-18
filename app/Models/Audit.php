<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;
    protected $primaryKey = 'audit_id';

    protected $fillable = [
        'user_id',
        'audit_desc',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'audit_desc' => 'encrypted',
    ];
}
