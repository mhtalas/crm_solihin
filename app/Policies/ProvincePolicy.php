<?php

namespace App\Policies;

use App\Models\Province;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProvincePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list province']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Province $province): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view province']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create province']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Province $province): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update province']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Province $province): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete province']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Province $province): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore province']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Province $province): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete province']);
    }
}
