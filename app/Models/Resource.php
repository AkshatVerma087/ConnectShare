<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Resource extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'type',
        'status',
        'location',
        'contact_email',
        'cover_image',
    ];

    /**
     * Auto-generate a unique slug before creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Resource $resource) {
            $resource->slug = Str::slug($resource->title) . '-' . Str::random(6);
        });
    }

    // ── Relationships ───────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ResourceImage::class)->orderBy('order');
    }

    // ── Scopes ──────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
