<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\Customer;
use App\Models\PipelineStage;
use App\Models\Project;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


// ...

    public function getTabs(): array
    {
        $currentUser = auth()->user();
        $isAdmin = $currentUser->hasRole('Super Admin') || $currentUser->hasRole('Admin');

        $tabs = [];

        // Adding `all` as our first tab
        $tabs['all'] = Tab::make('All Projects')
            // We will add a badge to show how many projects are in this tab
            ->badge($isAdmin ? Project::withoutTrashed()->count() : Project::withoutTrashed()->where('employee_id', $currentUser->id)->count());

        // Load all Pipeline Stages
        $pipelineStages = PipelineStage::orderBy('position')->withCount('projects')->get();

        foreach ($pipelineStages as $pipelineStage) {
            // Add a tab for each Pipeline Stage
            // Array index is going to be used in the URL as a slug, so we transform the name into a slug
            $tabs[str($pipelineStage->name)->slug()->toString()] = Tab::make($pipelineStage->name)
                // We will add a badge to show how many projects are in this tab
                ->badge($isAdmin ? $pipelineStage->projects_count : Project::withoutTrashed()->where('employee_id', $currentUser->id)->where('pipeline_stage_id', $pipelineStage->id)->count())
                // We will modify the query to only show projects in this Pipeline Stage
                ->modifyQueryUsing(function ($query) use ($pipelineStage, $isAdmin, $currentUser) {
                    if ($isAdmin) {
                        // Super Admin or Admin can see all projects
                        return $query->withoutTrashed()->where('pipeline_stage_id', $pipelineStage->id);
                    } else {
                        // Other roles can see projects based on employee_id and pipeline_stage_id
                        return $query->withoutTrashed()->where('employee_id', $currentUser->id)->where('pipeline_stage_id', $pipelineStage->id);
                    }
                });
        }

        // Adding `archived` tab for archived projects
        $tabs['archived'] = Tab::make('Archived')
            ->badge(Project::onlyTrashed()->count())
            ->modifyQueryUsing(function ($query) {
                return $query->onlyTrashed();
            });

        return $tabs;
    }

}
