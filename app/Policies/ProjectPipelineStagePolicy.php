<?php

namespace App\Policies;

use App\Models\ProjectPipelineStage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPipelineStagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['list project pipeline stage']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectPipelineStage $projectPipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['view project pipeline stage']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['create project pipeline stage']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectPipelineStage $projectPipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['update project pipeline stage']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectPipelineStage $projectPipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['delete project pipeline stage']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectPipelineStage $projectPipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['restore project pipeline stage']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectPipelineStage $projectPipelineStage): bool
    {
        return $user->hasRole('Admin') || $user->hasAnyPermission(['force delete project pipeline stage']);
    }
}
