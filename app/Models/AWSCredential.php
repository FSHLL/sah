<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AWSCredential extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'access_key_id',
        'access_key_secret',
    ];

    protected $cast = [
        'access_key_secret' => 'encrypt',
    ];

    protected $hidden = [
        'access_key_secret',
    ];
}