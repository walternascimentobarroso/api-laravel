<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\option;
use App\Models\Question;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * php artisan test --filter OptionTest
 */
class OptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test list all options.
     *
     * @return void
     */
    public function test_list_all_options()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('options.index'));
        $response->assertStatus(200);
        $response->assertJsonFragment(['current_page' => 1]);
    }

    /**
     * A feature test list all options without_authentication.
     *
     * @return void
     */
    public function test_cannot_list_all_options_without_authentication()
    {
        $response = $this->getJson(route('options.index'));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test create one option.
     *
     * @return void
     */
    public function test_create_one_option()
    {
        Sanctum::actingAs(User::factory()->create());

        $question = Question::factory()->create();

        $response = $this->postJson(route('options.store'), [
            "question_id" => $question->id,
            "text" => "option",
            "correct" => true
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['text' => 'option']);
    }

    /**
     * A feature test create one options without authentication.
     *
     * @return void
     */
    public function test_cannot_create_one_option_without_authentication()
    {
        $response = $this->postJson(route('options.store'));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test cannot create one option without find question.
     *
     * @return void
     */
    public function test_cannot_create_one_option_without_find_question()
    {
        Sanctum::actingAs(User::factory()->create(), ["question_id" => 0]);

        $response = $this->postJson(route('options.store'));
        $response->assertStatus(404);
        $response->assertJsonFragment(['Question not found.']);
    }

    /**
     * A feature test get one option.
     *
     * @return void
     */
    public function test_get_one_option()
    {
        Sanctum::actingAs(User::factory()->create());

        $option = Option::factory()->create();
        $response = $this->getJson(route('options.show', $option->id));
        $response->assertStatus(200);
        $response->assertJsonFragment(['text' => $option->text]);
    }

    /**
     * A feature test cannot get one option without authentication.
     *
     * @return void
     */
    public function test_cannot_get_one_option_without_authentication()
    {
        $option = option::factory()->create();
        $response = $this->getJson(route('options.show', $option->id));

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test cannot get one option.
     *
     * @return void
     */
    public function test_cannot_get_one_option()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('options.show', 0));
        $response->assertStatus(404);
    }

    /**
     * A feature test update one option.
     *
     * @return void
     */
    public function test_update_one_option()
    {
        Sanctum::actingAs(User::factory()->create());

        $option = option::factory()->create();
        $response = $this->putJson(route('options.update', $option->id), [
            'text' => 'New option name'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['text' => 'New option name']);
    }

    /**
     * A feature test cannot update one option without authentication.
     *
     * @return void
     */
    public function test_cannot_update_one_option_without_authentication()
    {
        $option = option::factory()->create();
        $response = $this->putJson(route('options.update', $option->id), [
            'name' => 'New option name'
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test cannot update one option without find it.
     *
     * @return void
     */
    public function test_cannot_update_one_option_without_find_it()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->putJson(route('options.update', 0), ['name' => 'New option name']);

        $response->assertStatus(404);
        $response->assertJsonFragment(['Not Found']);
    }

    /**
     * A feature test delete one option.
     *
     * @return void
     */
    public function test_delete_one_option()
    {
        Sanctum::actingAs(User::factory()->create());

        $option = option::factory()->create();

        $response = $this->deleteJson(route('options.destroy', $option->id));
        $response->assertStatus(200);
        $response->assertJsonFragment(['Option deleted!']);
    }

    /**
     * A feature test cannot delete one option without authentication.
     *
     * @return void
     */
    public function test_cannot_delete_one_option_without_authentication()
    {
        $option = option::factory()->create();
        $response = $this->deleteJson(route('options.destroy', $option->id));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }


    /**
     * A feature test cannot delete one option  without find it.
     *
     * @return void
     */
    public function test_cannot_delete_one_option_without_find_it()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->deleteJson(route('options.destroy', 0));
        $response->assertStatus(404);
        $response->assertJsonFragment(['Not Found']);
    }
}
