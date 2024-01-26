<?php

namespace App\Policies;

use App\Models\ProductItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list product item']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductItem $productItem): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view product item']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create product item']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductItem $productItem): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update product item']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductItem $productItem): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete product item']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductItem $productItem): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore product item']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductItem $productItem): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete product item']);
    }
}
