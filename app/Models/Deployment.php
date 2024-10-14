<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deployment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'project_id',
        'stack_resources',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
