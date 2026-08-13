<?php

namespace App\Policies;

use App\Models\Galleries;
use App\Models\User;

class GalleriesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_galleries');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Galleries $galleries): bool
    {
        return $user->can('view_galleries');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_galleries');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Galleries $galleries): bool
    {
        return $user->can('update_galleries');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Galleries $galleries): bool
    {
        return $user->can('delete_galleries');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Galleries $galleries): bool
    {
        return $user->can('restore_galleries');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Galleries $galleries): bool
    {
        return $user->can('force_delete_galleries');
    }
}
