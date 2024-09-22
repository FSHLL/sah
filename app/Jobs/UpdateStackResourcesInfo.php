<?php

namespace App\Jobs;

use App\Factories\FunctionServiceFactory;
use App\Factories\StackResourcesFactory;
use App\Factories\StackServiceFactory;
use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class UpdateStackResourcesInfo implements ShouldQueue
{
    use Queueable;

    public function __construct(private Project $project)
    {
        //
    }

    public function handle(): void
    {
        $stackService = StackServiceFactory::create($this->project->credential->type->value);
        $functionService = FunctionServiceFactory::create($this->project->credential->type->value);

        $stack = $stackService->getStack($this->project->credential, $this->project->stack_id)->toArray();

        $stackObject = StackResourcesFactory::create(
            $this->project->credential->type->value,
            $stack
        );

        foreach ($stackObject->getAliases() as $function) {
            try {
                $stack['Triggers'][] = json_decode($functionService->getTriggers(
                    $this->project->credential,
                    $function,
                )->get('Policy'), true);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }
        }

        $this->project->stack_resources = StackResourcesFactory::create(
            $this->project->credential->type->value,
            $stack
        );

        $this->project->save();
    }
}
