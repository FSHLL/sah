<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'stack_id',
        'stack_resources',
        'user_id',
        'credential_id',
    ];

    public function credential(): BelongsTo
    {
        return $this->belongsTo(Credential::class);
    }

    public function deploys(): HasMany
    {
        return $this->hasMany(Deploy::class);
    }

    protected function casts()
    {
        return [
            'stack_resources' => 'array',
        ];
    }
}
