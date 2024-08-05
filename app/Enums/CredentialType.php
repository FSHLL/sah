<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;

enum CredentialType: string
{
    use InteractWithEnum;

    case AWS = 'aws';
    case AZURE = 'azure';
}
