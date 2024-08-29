<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_retrieve_list_of_tasks()
    {
        // Create tasks with associated projects
        Task::factory()
            ->count(3)
            ->for(Project::factory())
            ->create();

        // Send request
        $response = $this->actingAs($this->user)->getJson('/api/task');

        // Assert response status and JSON structure
        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'data',
                    3,
                    fn (AssertableJson $json) =>
                    $json->whereType('id', 'integer')
                        ->whereType('project_id', 'integer')
                        ->whereType('name', 'string')
                        ->whereType('description', 'string')
                        ->whereType('status', 'string')
                        ->whereType('created_at', 'string')
                        ->has(
                            'project',
                            fn (AssertableJson $json) =>
                            $json->whereType('id', 'integer')
                                ->whereType('name', 'string')
                                ->whereType('description', 'string')
                                ->whereType('created_at', 'string')
                                ->whereType('updated_at', 'string')
                                ->whereType('tasks', 'array')
                        )
                )
            );
    }

    public function test_can_store_new_task()
    {
        $project = Project::factory()->create();

        $data = [
            'project_id' => $project->id,
            'name' => 'Test Task',
            'description' => 'This is a test task description',
            'status' => 'todo'
        ];

        $response = $this->actingAs($this->user)->postJson('/api/task', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'project_id' => $data['project_id'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                ]
            ]);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function test_can_update_task()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create();

        $data = [
            'project_id' => $project->id,
            'name' => 'Updated Task Name',
            'description' => 'Updated task description',
            'status' => 'done'
        ];

        $response = $this->actingAs($this->user)->putJson("/api/task/{$task->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                ]
            ]);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson("/api/task/{$task->id}");

        $response->assertStatus(202);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_can_retrieve_specific_task()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)->getJson("/api/task/show/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $task->id,
                    'project_id' => $task->project_id,
                    'name' => $task->name,
                    'description' => $task->description,
                    'status' => $task->status,
                ]
            ]);
    }
}
