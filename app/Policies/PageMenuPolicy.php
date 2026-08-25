<?php

namespace App\Policies;

use App\Models\PageMenu;
use App\Models\User;

class PageMenuPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_page::menu');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageMenu $pageMenu): bool
    {
        return $user->can('view_page::menu');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_page::menu');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageMenu $pageMenu): bool
    {
        return $user->can('update_page::menu');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PageMenu $pageMenu): bool
    {
        return $user->can('delete_page::menu');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PageMenu $pageMenu): bool
    {
        return $user->can('restore_page::menu');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PageMenu $pageMenu): bool
    {
        return $user->can('force_delete_page::menu');
    }
}
