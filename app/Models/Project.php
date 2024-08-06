<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'stack_id',
        'user_id',
        'credential_id',
    ];

    public function credential(): HasOne
    {
        return $this->hasOne(Credential::class);
    }

    public function deploys(): HasMany
    {
        return $this->hasMany(Deploy::class);
    }
}
