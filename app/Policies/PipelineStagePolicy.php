<?php

namespace App\Policies;

use App\Models\PipelineStage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PipelineStagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list pipeline stage']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PipelineStage $pipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view pipeline stage']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create pipeline stage']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PipelineStage $pipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update pipeline stage']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PipelineStage $pipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete pipeline stage']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PipelineStage $pipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore pipeline stage']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PipelineStage $pipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete pipeline stage']);
    }
}
