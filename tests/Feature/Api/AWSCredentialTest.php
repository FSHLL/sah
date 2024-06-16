<?php

namespace Tests\Feature\Api;

use App\Models\AWSCredential;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AWSCredentialTest extends TestCase
{
    use RefreshDatabase;

    const PATH = 'api/aws-credential';

    public function testAWSCredentialCanBeCreated(): void
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

    public function testAWSCredentialCanBeShowed(): void
    {
        $user = User::factory()->create();
        $awsCredential = AWSCredential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH.'/'.$awsCredential->id);

        $response
            ->assertOk()
            ->assertJson([
                'id' => $awsCredential->id,
                'access_key_id' => $awsCredential->access_key_id,
            ]);
    }

    public function testAWSCredentialCanBeUpdated(): void
    {
        $user = User::factory()->create();
        $awsCredential = AWSCredential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->patch(self::PATH.'/'.$awsCredential->id, [
                'access_key_id' => 'key-updated',
                'access_key_secret' => 'secret-updated',
            ]);

        $response
            ->assertOk()
            ->assertJson([
                'access_key_id' => 'key-updated',
            ]);
    }

    public function testAWSCredentialCanBeDeleted(): void
    {
        $user = User::factory()->create();
        $awsCredential = AWSCredential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->delete(self::PATH.'/'.$awsCredential->id);

        $response->assertOk();

        $this->assertDatabaseMissing(AWSCredential::class, $awsCredential->toArray());
    }

    public function testAWSCredentialNotCanBeShowedIfIsFromOtherUser(): void
    {
        $user = User::factory()->create();
        $awsCredential = AWSCredential::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH.'/'.$awsCredential->id);

        $response->assertNotFound();
    }
}
