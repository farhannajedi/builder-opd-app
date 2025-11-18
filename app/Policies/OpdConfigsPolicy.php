<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OpdConfigs;
use Illuminate\Auth\Access\HandlesAuthorization;

class OpdConfigsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super admin'); //$user->can('view_any_opd::configs');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OpdConfigs $opdConfigs): bool
    {
        return $user->hasRole('super admin'); //$user->can('view_opd::configs');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super admin'); // $user->can('create_opd::configs');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OpdConfigs $opdConfigs): bool
    {
        return $user->hasRole('super admin'); // $user->can('update_opd::configs');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OpdConfigs $opdConfigs): bool
    {
        return $user->hasRole('super admin'); // $user->can('delete_opd::configs');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasRole('super admin'); // $user->can('{{ DeleteAny }}');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, OpdConfigs $opdConfigs): bool
    {
        return $user->hasRole('super admin'); // $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->hasRole('super admin'); // $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, OpdConfigs $opdConfigs): bool
    {
        return $user->hasRole('super admin'); // $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->hasRole('super admin'); // $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, OpdConfigs $opdConfigs): bool
    {
        return $user->hasRole('super admin'); // $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->hasRole('super admin'); // $user->can('{{ Reorder }}');
    }
}
