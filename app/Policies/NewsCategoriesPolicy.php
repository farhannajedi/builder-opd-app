<?php

namespace App\Policies;

use App\Models\NewsCategories;
use App\Models\User;

class NewsCategoriesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_news_categories');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NewsCategories $newsCategories): bool
    {
        return $user->can('view_news_categories');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_news_categories');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NewsCategories $newsCategories): bool
    {
        return $user->can('update_news_categories');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NewsCategories $newsCategories): bool
    {
        return $user->can('delete_news_categories');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NewsCategories $newsCategories): bool
    {
        return $user->can('restore_news_categories');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NewsCategories $newsCategories): bool
    {
        return $user->can('force_delete_news_categories');
    }
}
