<?php

namespace Database\Factories;

use App\Models\AWSCredential;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(10),
            'stack_id' => $this->faker->text(10),
            'user_id' => User::factory(),
            'a_w_s_credential_id' => AWSCredential::factory(),
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn () => [
            'user_id' => $user,
        ]);
    }
}
