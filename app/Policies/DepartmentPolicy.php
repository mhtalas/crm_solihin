<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list department']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Department $department): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view department']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create department']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Department $department): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update department']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Department $department): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete department']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Department $department): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore department']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Department $department): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete department']);
    }
}
