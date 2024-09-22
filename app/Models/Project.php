<?php

namespace App\Models;

use App\Casts\StackResources;
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

    public function deployments(): HasMany
    {
        return $this->hasMany(Deployment::class);
    }

    protected function casts(): array
    {
        return [
            'stack_resources' => StackResources::class,
        ];
    }
}
