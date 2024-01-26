<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list customer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view customer']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create customer']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update customer']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete customer']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore customer']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete customer']);
    }
}
