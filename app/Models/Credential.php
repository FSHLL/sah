<?php

namespace App\Models;

use App\Casts\CredentialSettings;
use App\Enums\CredentialType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'settings',
        'type',
        'user_id',
        'days',
    ];

    protected $hidden = [
        'access_key_secret',
        'settings',
    ];

    protected function casts()
    {
        return [
            'settings' => CredentialSettings::class,
            'type' => CredentialType::class,
        ];
    }
}
