<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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
        if (Str::isUrl($this->path)) {
            return $this->path;
        }

        return asset('storage/' . $this->path);
    }
}
