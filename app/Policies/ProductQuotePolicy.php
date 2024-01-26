<?php

namespace App\Policies;
use App\Models\ProductQuote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductQuotePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list product quote']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductQuote $productQuote): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view product quote']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create product quote']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductQuote $productQuote): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update product quote']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductQuote $productQuote): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete product quote']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductQuote $productQuote): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore product quote']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductQuote $productQuote): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete product quote']);
    }
}
