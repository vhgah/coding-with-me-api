<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'status',
        'published_at',
        'category_id',
        'admin_id',
        'featured_image',
    ];

    protected $casts = [
        //
    ];

    protected $dates = [
        'published_at'
    ];

    /**
     * Scope a query to only include popular users.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', PostStatusEnum::ACTIVE);
    }

    public function isActive()
    {
        return $this->status === PostStatusEnum::ACTIVE;
    }

    public function getFormattedPublishedAtAttribute()
    {
        return Carbon::parse($this->published_at)->format('M j, Y');
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
