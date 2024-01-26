<?php

namespace App\Policies;

use App\Models\LeadSource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadSourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list lead source']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeadSource $leadSource): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view lead source']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create lead source']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeadSource $leadSource): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update lead source']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeadSource $leadSource): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete lead source']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeadSource $leadSource): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore lead source']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeadSource $leadSource): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete lead source']);
    }
}
