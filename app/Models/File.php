<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
        'type',
    ];

    public function getUrl(): string
    {
        return asset('storage/' . $this->path);
    }
}
