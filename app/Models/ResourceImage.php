<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceImage extends Model
{
    protected $fillable = ['resource_id', 'path', 'order'];

    /**
     * Get the resource this image belongs to.
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
