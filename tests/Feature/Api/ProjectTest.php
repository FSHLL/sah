<?php

namespace Tests\Feature\Api;

use App\Models\AWSCredential;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    const PATH = 'api/project';

    public function testProjectCanBeCreated(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $awsCredential = AWSCredential::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->post(self::PATH, [
                'name' => 'my app',
                'stack_id' => 'id',
                'a_w_s_credential_id' => $awsCredential->id,
                'user_id' => $user->id,
            ]);

        $response
            ->assertCreated()
            ->assertJson([
                'name' => 'my app',
                'stack_id' => 'id',
            ]);
    }

    public function testProjectCanBeShowed(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH.'/'.$project->id);

        $response
            ->assertOk()
            ->assertJson([
                'id' => $project->id,
                'stack_id' => $project->stack_id,
            ]);
    }

    public function testProjectCanBeUpdated(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->patch(self::PATH.'/'.$project->id, [
                'name' => 'my app update',
                'stack_id' => 'id updated',
            ]);

        $response
            ->assertOk()
            ->assertJson([
                'name' => 'my app update',
                'stack_id' => 'id updated',
            ]);
    }

    public function testProjectCanBeDeleted(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->forUser($user)->create();

        $response = $this
            ->actingAs($user)
            ->delete(self::PATH.'/'.$project->id);

        $response->assertOk();

        $this->assertDatabaseMissing(Project::class, $project->toArray());
    }

    public function testProjectNotCanBeShowedIfIsFromOtherUser(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(self::PATH.'/'.$project->id);

        $response->assertNotFound();
    }
}
