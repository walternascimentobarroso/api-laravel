<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * php artisan test --filter AuthTest
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test register.
     *
     * @return void
     */
    public function test_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'test',
            'email' => 'vhalvorson@example.net.brx',
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'test']);
    }

    /**
     * A feature test cannot register withou name.
     *
     * @return void
     */
    public function test_cannot_register_withou_name()
    {
        $response = $this->postJson(route('auth.register'), [
            'email' => 'vhalvorson@example.net.brx',
            'password' => 'password'
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment(['The name field is required.']);
    }

    /**
     * A feature test cannot register withou email.
     *
     * @return void
     */
    public function test_cannot_register_withou_email()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'test',
            'password' => 'password'
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment(['The email field is required.']);
    }

    /**
     * A feature test cannot register withou password.
     *
     * @return void
     */
    public function test_cannot_register_withou_password()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'test',
            'email' => 'vhalvorson@example.net.brx',
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment(['The password field is required.']);
    }

    /**
     * A feature test cannot register more than one email.
     *
     * @return void
     */
    public function test_cannot_register_more_than_one_email()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.register'), [
            'name' => 'test',
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['The email is already registered!']);
    }

    /**
     * A feature test login.
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }

    /**
     * A feature test cannot login with invalid redentials.
     *
     * @return void
     */
    public function test_cannot_login_with_invalid_redentials()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => 'emailinvalido',
            'password' => 'password2',
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['Invalid Credentials']);
    }

    /**
     * A feature test logout.
     *
     * @return void
     */
    public function test_logout()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson(route('auth.logout'));
        $response->assertNoContent();
    }

    /**
     * A feature test cannot logout without authentication.
     *
     * @return void
     */
    public function test_cannot_logout_without_authentication()
    {
        $response = $this->postJson(route('auth.logout'));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /**
     * A feature test get me.
     *
     * @return void
     */
    public function test_get_me()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('auth.me'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['name']);
    }

    /**
     * A feature test cannot get me without authentication.
     *
     * @return void
     */
    public function test_cannot_get_me_without_authentication()
    {
        $response = $this->getJson(route('auth.me'));
        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }
}
