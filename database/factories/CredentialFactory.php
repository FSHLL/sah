<?php

namespace Database\Factories;

use App\Models\User;
use App\Settings\Credentials\AWSCredentialSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\<Credential>
 */
class CredentialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'settings' => new AWSCredentialSettings([
                'access_key_id' => $this->faker->text(120),
                'access_key_secret' => $this->faker->text(120),
            ]),
            'user_id' => User::factory(),
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn () => [
            'user_id' => $user,
        ]);
    }
}
