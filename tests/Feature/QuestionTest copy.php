<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Option;
use App\Models\Question;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * php artisan test --filter QuestionTest
 */
class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test list all questions.
     *
     * @return void
     */
    public function test_list_all_questions()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('questions.index'));
        $response->assertStatus(200);
        $response->assertJsonFragment(['current_page' => 1]);
    }

    /**
     * A feature test list all questions without_authentication.
     *
     * @return void
     */
    public function test_cannot_list_all_questions_without_authentication()
    {
        $response = $this->getJson(route('questions.index'));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test create one question.
     *
     * @return void
     */
    public function test_create_one_question()
    {
        Sanctum::actingAs(User::factory()->create());

        $question = Question::factory()->create();

        $response = $this->postJson(route('questions.store'), [
            "question_id" => $question->id,
            "text" => "question",
            "correct" => true
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['text' => 'question']);
    }

    /**
     * A feature test create one questions without authentication.
     *
     * @return void
     */
    public function test_cannot_create_one_question_without_authentication()
    {
        $response = $this->postJson(route('questions.store'));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test cannot create one question without find question.
     *
     * @return void
     */
    public function test_cannot_create_one_question_without_find_question()
    {
        Sanctum::actingAs(User::factory()->create(), ["question_id" => 0]);

        $response = $this->postJson(route('questions.store'));
        $response->assertStatus(404);
        $response->assertJsonFragment(['Question not found.']);
    }

    /**
     * A feature test get one question.
     *
     * @return void
     */
    public function test_get_one_question()
    {
        Sanctum::actingAs(User::factory()->create());

        $question = question::factory()->create();
        $response = $this->getJson(route('questions.show', $question->id));
        $response->assertStatus(200);
        $response->assertJsonFragment(['text' => $question->text]);
    }

    /**
     * A feature test cannot get one question without authentication.
     *
     * @return void
     */
    public function test_cannot_get_one_question_without_authentication()
    {
        $question = question::factory()->create();
        $response = $this->getJson(route('questions.show', $question->id));

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test cannot get one question.
     *
     * @return void
     */
    public function test_cannot_get_one_question()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('questions.show', 0));
        $response->assertStatus(404);
    }

    /**
     * A feature test update one question.
     *
     * @return void
     */
    public function test_update_one_question()
    {
        Sanctum::actingAs(User::factory()->create());

        $question = question::factory()->create();
        $response = $this->putJson(route('questions.update', $question->id), [
            'text' => 'New question name'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['text' => 'New question name']);
    }

    /**
     * A feature test cannot update one question without authentication.
     *
     * @return void
     */
    public function test_cannot_update_one_question_without_authentication()
    {
        $question = question::factory()->create();
        $response = $this->putJson(route('questions.update', $question->id), [
            'name' => 'New question name'
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test cannot update one question without find it.
     *
     * @return void
     */
    public function test_cannot_update_one_question_without_find_it()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->putJson(route('questions.update', 0), ['name' => 'New question name']);

        $response->assertStatus(404);
        $response->assertJsonFragment(['Not Found']);
    }

    /**
     * A feature test delete one question.
     *
     * @return void
     */
    public function test_delete_one_question()
    {
        Sanctum::actingAs(User::factory()->create());

        $question = question::factory()->create();

        $response = $this->deleteJson(route('questions.destroy', $question->id));
        $response->assertStatus(200);
        $response->assertJsonFragment(['question deleted!']);
    }

    /**
     * A feature test cannot delete one question without authentication.
     *
     * @return void
     */
    public function test_cannot_delete_one_question_without_authentication()
    {
        $question = question::factory()->create();
        $response = $this->deleteJson(route('questions.destroy', $question->id));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }


    /**
     * A feature test cannot delete one question  without find it.
     *
     * @return void
     */
    public function test_cannot_delete_one_question_without_find_it()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->deleteJson(route('questions.destroy', 0));
        $response->assertStatus(404);
        $response->assertJsonFragment(['Not Found']);
    }
}
