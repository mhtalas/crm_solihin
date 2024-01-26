<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded;

    public function pipelineStage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function pipelineStageLogs(): HasMany
    {
        return $this->hasMany(ProjectPipelineStage::class);
    }

    public function pipelineStageLogs_visit() {
        return $this->pipelineStageLogs()->where('pipeline_stage_id','=', 2);
    }

    public function pipelineStageLogs_proposed() {
        return $this->pipelineStageLogs()->where('pipeline_stage_id','=', 3);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public static function booted(): void
    {
        self::created(function (Project $project) {
            $project->pipelineStageLogs()->create([
                'pipeline_stage_id' => $project->pipeline_stage_id,
                'employee_id' => $project->employee_id,
                'user_id' => auth()->check() ? auth()->id() : null
            ]);
        });

        self::updated(function (Project $project) {
            $lastLog = $project->pipelineStageLogs()->whereNotNull('employee_id')->latest()->first();

            // Here, we will check if the employee has changed, and if so - add a new log
            if ($lastLog && $project->employee_id !== $lastLog?->employee_id) {
                $project->pipelineStageLogs()->create([
                    'employee_id' => $project->employee_id,
                    'notes' => is_null($project->employee_id) ? 'Project removed' : '',
                    'user_id' => auth()->id()
                ]);
            }
        });
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function completedTasks(): HasMany
    {
        return $this->hasMany(Task::class)->where('is_completed', true);
    }

    public function incompleteTasks(): HasMany
    {
        return $this->hasMany(Task::class)->where('is_completed', false);
    }

    public function quotes() : HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function actuals() : HasMany
    {
        return $this->hasMany(ProjectActual::class);
    }
}
