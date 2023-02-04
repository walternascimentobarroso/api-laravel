<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test list all tasks.
     *
     * @return void
     */
    public function test_list_all_tasks()
    {
        $response = $this->getJson(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['current_page' => 1]);
    }

    /**
     * A feature test create one task.
     *
     * @return void
     */
    public function test_create_one_task()
    {
        $response = $this->postJson(route('tasks.store'), [
            'name' => 'Task',
            'done' => true,
            'due_date' => '2023-01-01',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => 'Task']);
    }

    /**
     * A feature test cannot create one task without name.
     *
     * @return void
     */
    public function test_cannot_create_one_task_without_name()
    {
        $response = $this->postJson(route('tasks.store'), [
            'done' => true,
            'due_date' => '2023-01-01',
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['The name field is required.']);
    }

    /**
     * A feature test cannot create one task without done.
     *
     * @return void
     */
    public function test_cannot_create_one_task_without_done()
    {
        $response = $this->postJson(route('tasks.store'), ['name' => 'Task', 'due_date' => '2023-01-01']);

        $response->assertStatus(422);
        $response->assertJsonFragment(['The done field is required.']);
    }

    /**
     * A feature test get one task.
     *
     * @return void
     */
    public function test_get_one_task()
    {
        $task = Task::factory()->create();
        $response = $this->getJson(route('tasks.show', $task->id));
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $task->name]);
    }

    /**
     * A feature test cannot get one task.
     *
     * @return void
     */
    public function test_cannot_get_one_task()
    {
        $response = $this->getJson(route('tasks.show', 0));
        $response->assertStatus(404);
    }

    /**
     * A feature test update one task.
     *
     * @return void
     */
    public function test_update_one_task()
    {
        $task = Task::factory()->create();
        $response = $this->putJson(route('tasks.update', $task->id), [
            'name' => 'New Task name'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => 'New Task name']);
    }

    /**
     * A feature test cannot update one task without name.
     *
     * @return void
     */
    public function test_cannot_update_one_task_without_name()
    {
        $task = Task::factory()->create();
        $response = $this->putJson(route('tasks.update', $task->id), []);

        $response->assertStatus(422);
        $response->assertJsonFragment(['The name field is required.']);
    }

    /**
     * A feature test cannot update one task without find it.
     *
     * @return void
     */
    public function test_cannot_update_one_task_without_find_it()
    {
        $response = $this->putJson(route('tasks.update', 0), ['name' => 'New Task name']);

        $response->assertStatus(404);
        $response->assertJsonFragment(['Task not found']);
    }

    /**
     * A feature test delete one task.
     *
     * @return void
     */
    public function test_delete_one_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('tasks.destroy', $task->id));
        $response->assertStatus(200);
        $response->assertJsonFragment(['Task deleted!']);
    }

    /**
     * A feature test cannot delete one task  without find it.
     *
     * @return void
     */
    public function test_cannot_delete_one_task_without_find_it()
    {
        $response = $this->deleteJson(route('tasks.destroy', 0));
        $response->assertStatus(404);
        $response->assertJsonFragment(['Task not found']);
    }
}
