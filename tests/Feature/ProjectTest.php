<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_retrieve_list_of_projects()
    {
        $projects = Project::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->getJson('/api/project');

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'data',
                    3,
                    fn (AssertableJson $json) =>
                    $json->whereType('id', 'integer')
                        ->whereType('name', 'string')
                        ->whereType('description', 'string')
                        ->whereType('created_at', 'string')
                        ->whereType('updated_at', 'string')
                        ->whereType('tasks', 'array')
                )
            );
    }

    public function test_can_store_new_project()
    {
        $data = [
            'name' => 'Test Project',
            'description' => 'This is a test project description',
        ];

        $response = $this->actingAs($this->user)->postJson('/api/project', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]
            ]);

        $this->assertDatabaseHas('projects', $data);
    }

    public function test_can_update_project()
    {
        $project = Project::factory()->create();

        $data = [
            'name' => 'Updated Project Name',
            'description' => 'Updated project description',
        ];

        $response = $this->actingAs($this->user)->putJson("/api/project/{$project->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]
            ]);

        $this->assertDatabaseHas('projects', $data);
    }

    public function test_can_delete_project()
    {
        $project = Project::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson("/api/project/{$project->id}");

        $response->assertStatus(202);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_can_retrieve_specific_project()
    {
        $project = Project::factory()->create();

        $response = $this->actingAs($this->user)->getJson("/api/project/show/{$project->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,
                ]
            ]);
    }

    public function test_unauthorized_user_cannot_retrieve_list_of_projects()
    {
        $projects = Project::factory()->count(3)->create();

        $response = $this->getJson('/api/project');

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_unauthorized_user_cannot_update_project()
    {
        $project = Project::factory()->create();

        $data = [
            'name' => 'Updated Project Name',
            'description' => 'Updated project description',
        ];

        $response = $this->putJson("/api/project/{$project->id}", $data);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_unauthorized_user_cannot_delete_project()
    {
        $project = Project::factory()->create();

        $response = $this->deleteJson("/api/project/{$project->id}");

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_unauthorized_user_cannot_store_project()
    {
        $data = [
            'name' => 'Unauthorized Project',
            'description' => 'This should not be stored',
        ];

        $response = $this->postJson('/api/project', $data);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}
