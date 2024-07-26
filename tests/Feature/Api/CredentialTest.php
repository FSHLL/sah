<?php

namespace Tests\Feature\Api;

use App\Models\Credential;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CredentialTest extends TestCase
{
    use RefreshDatabase;

    const PATH = 'api/credentials';

    public function testCredentialsCanBeListed(): void
    {
        $user = User::factory()->create();

        Credential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH);

        $response
            ->assertOk()
            ->assertJson([
                'total' => 1
            ]);
    }

    public function testCredentialsCanListsOnlyUserCreated(): void
    {
        $user = User::factory()->create();

        Credential::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH);

        $response
            ->assertOk()
            ->assertJson([
                'total' => 0
            ]);
    }

    public function testCredentialCanBeCreated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(self::PATH, [
                'access_key_id' => 'key',
                'access_key_secret' => 'secret',
            ]);

        $response
            ->assertCreated()
            ->assertJson([
                'access_key_id' => 'key'
            ]);
    }

    public function testCredentialCanBeShowed(): void
    {
        $user = User::factory()->create();
        $credential = Credential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH.'/'.$credential->id);

        $response
            ->assertOk()
            ->assertJson([
                'id' => $credential->id,
                'access_key_id' => $credential->access_key_id,
            ]);
    }

    public function testCredentialCanBeUpdated(): void
    {
        $user = User::factory()->create();
        $credential = Credential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->patch(self::PATH.'/'.$credential->id, [
                'access_key_id' => 'key-updated',
                'access_key_secret' => 'secret-updated',
            ]);

        $response
            ->assertOk()
            ->assertJson([
                'access_key_id' => 'key-updated',
            ]);
    }

    public function testCredentialCanBeDeleted(): void
    {
        $user = User::factory()->create();
        $credential = Credential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->delete(self::PATH.'/'.$credential->id);

        $response->assertOk();

        $this->assertDatabaseMissing(Credential::class, $credential->toArray());
    }

    public function testCredentialNotCanBeShowedIfIsFromOtherUser(): void
    {
        $user = User::factory()->create();
        $credential = Credential::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH.'/'.$credential->id);

        $response->assertNotFound();
    }
}
