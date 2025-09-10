<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_tasks()
    {
        Task::factory()->count(2)->create();

        $response = $this->getJson('/');

        $response->assertStatus(200);
    }

    public function test_create_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test desc'
        ];

        $response = $this->postJson('/tasks', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_update_status()
    {
        $task = Task::factory()->create();

        $response = $this->patchJson("/tasks/{$task->id}/status", [
            'status' => 'done'
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_validation_error()
    {
        $response = $this->postJson('/tasks', []);

        $response->assertStatus(422);
    }
}