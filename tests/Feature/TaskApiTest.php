<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function testGetTasks()
    {
        $user = User::factory()->create();
        $tasks = Task::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function testCreateTask()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/tasks', [
                'title' => 'Test title',
                'description' => 'Test description',
                'assignee_id' => $user->id,
                'due_date' => '2023-05-01 01:14:39',
                'status' => 'pending',
                'user_id' => $user->id,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test title',
            'description' => 'Test description',
            'assignee_id' => $user->id,
            'due_date' => '2023-05-01 01:14:39',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);
    }

    public function testUpdateTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->putJson('/api/tasks/'.$task->id, [
                'title' => 'Updated title',
                'description' => 'Updated description',
                'assignee_id' => $user->id,
                'due_date' => '2023-05-01 01:14:39',
                'status' => 'completed',
                'user_id' => $user->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated title',
            'description' => 'Updated description',
            'assignee_id' => $user->id,
            'due_date' => '2023-05-01 01:14:39',
            'status' => 'completed',
            'user_id' => $user->id,
        ]);
    }

    public function testDeleteTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/tasks/'.$task->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
