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
        'user_id',
    ];

    protected $cast = [
        'access_key_secret' => 'encrypt',
    ];

    protected $hidden = [
        'access_key_secret',
    ];

    public function getConfig(): array
    {
        return [
            'credentials' => [
                'key'    => $this->access_key_id,
                'secret' => $this->access_key_secret,
            ],
            'region' => 'us-east-1',
        ];
    }
}
