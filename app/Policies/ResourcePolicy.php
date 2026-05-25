<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;

class ResourcePolicy
{
    /**
     * Any authenticated user can create a resource.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the resource owner can update it.
     */
    public function update(User $user, Resource $resource): bool
    {
        return $user->id === $resource->user_id;
    }

    /**
     * Only the resource owner can delete it.
     */
    public function delete(User $user, Resource $resource): bool
    {
        return $user->id === $resource->user_id;
    }
}
