<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'email',
        'password',
        'username',
        'status',
        'last_login_at',
        'ip_address',
    ];

    protected $hidden = [
        'password',
    ];
}
