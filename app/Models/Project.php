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
        'a_w_s_credential_id',
    ];

    public function awsCredential(): BelongsTo
    {
        return $this->belongsTo(AWSCredential::class);
    }

    public function deploys(): HasMany
    {
        return $this->hasMany(Deploy::class);
    }
}
