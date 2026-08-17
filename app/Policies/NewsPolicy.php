<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class NewsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_news');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, News $news): bool
    {
        if (!$user->can('view_news')) {
            return false;
        }

        // Super Admin dapat melihat semua OPD
        if ($user->opd_id === null) {
            return true;
        }

        // Admin OPD hanya dapat melihat berita OPD sendiri
        return $news->opd_id === $user->opd_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_news');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, News $news): bool
    {
        if (!$user->can('update_news')) {
            return false;
        }

        // Super Admin dapat mengubah berita semua OPD
        if ($user->opd_id === null) {
            return true;
        }

        // Admin OPD hanya dapat mengubah berita miliknya
        return $news->opd_id === $user->opd_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, News $news): bool
    {
        if (!$user->can('delete_news')) {
            return false;
        }

        // Super Admin dapat menghapus semua berita
        if ($user->opd_id === null) {
            return true;
        }

        // Admin OPD hanya dapat menghapus berita miliknya
        return $news->opd_id === $user->opd_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, News $news): bool
    {
        if (!$user->can('restore_news')) {
            return false;
        }

        if ($user->opd_id === null) {
            return true;
        }

        return $news->opd_id === $user->opd_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, News $news): bool
    {
        if (!$user->can('force_delete_news')) {
            return false;
        }

        if ($user->opd_id === null) {
            return true;
        }

        return $news->opd_id === $user->opd_id;
    }
}
