<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AWSCredential>
 */
class AWSCredentialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'access_key_id' => $this->faker->text(120),
            'access_key_secret' => $this->faker->text(120),
            'user_id' => User::factory(),
        ];
    }
}
