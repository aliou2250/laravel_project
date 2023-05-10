<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;


    public function testATaskBelongsToAnOwner()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $task->owner);
        $this->assertEquals($user->id, $task->owner->id);
    }


    public function testATaskBelongsToAnAssignee()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['assignee_id' => $user->id]);

        $this->assertInstanceOf(User::class, $task->assignee);
        $this->assertEquals($user->id, $task->assignee->id);
    }
}
