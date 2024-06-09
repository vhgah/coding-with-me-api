<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
        'referral_url',
        'country',
        'city',
        'state',
        'timezone',
        'browser',
        'platform',
        'device',
        'languages',
    ];

    protected $casts = [
        'languages' => 'array',
    ];
}
