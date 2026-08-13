<?php

namespace App\Policies;

use App\Models\PlanningDocument;
use App\Models\User;

class PlanningDocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_planning_document
        ');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanningDocument $planningDocument): bool
    {
        return $user->can('view_planning_document
        ');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_planning_document
        ');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanningDocument $planningDocument): bool
    {
        return $user->can('update_planning_document
        ');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanningDocument $planningDocument): bool
    {
        return $user->can('delete_planning_document
        ');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlanningDocument $planningDocument): bool
    {
        return $user->can('restore_planning_document
        ');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlanningDocument $planningDocument): bool
    {
        return $user->can('force_delete_planning_document
        ');
    }
}
