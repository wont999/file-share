<?php

namespace App\Policies;

use App\Models\FileLink;
use App\Models\User;
use App\Models\File;
use Illuminate\Auth\Access\Response;

class FileLinkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FileLink $link): bool
    {
        return $user->id === $link->file->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?File $file = null): bool
    {
        if (is_null($file)) {
            return true;
        }
        
        return $user->id === $file->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FileLink $link): bool
    {
        return $user->id === $link->file->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FileLink $link): bool
    {
        return $user->id === $link->file->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FileLink $link): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FileLink $link): bool
    {
        return false;
    }
}
