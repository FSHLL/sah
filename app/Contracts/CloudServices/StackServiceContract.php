<?php

namespace App\Contracts\CloudServices;

use App\Models\Credential;
use App\Models\Project;

interface StackServiceContract
{
    public function getStacks(Credential $credential);

    public function getStack(Credential $credential, string $stackId);

    public function getProjectStackInfo(Project $project);
}
