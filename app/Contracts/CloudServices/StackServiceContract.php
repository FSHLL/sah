<?php

namespace App\Contracts\CloudServices;

use App\Models\Credential;

interface StackServiceContract
{
    public function getStacks(Credential $credential);

    public function getStack(Credential $credential, string $stackId);
}
