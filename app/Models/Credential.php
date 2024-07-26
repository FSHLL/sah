<?php

namespace App\Models;

use App\Enums\CredentialType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'access_key_id',
        'access_key_secret',
        'type',
        'user_id',
    ];

    protected $cast = [
        'access_key_secret' => 'encrypt',
        'type' => CredentialType::class,
    ];

    protected $hidden = [
        'access_key_secret',
    ];
}
