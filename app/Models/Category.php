<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon'];

    /**
     * Get all resources in this category.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
