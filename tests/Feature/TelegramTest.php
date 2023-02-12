<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * php artisan test --filter TelegramTest
 */
class TelegramTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test_telegram_get_me.
     *
     * @return void
     */
    public function test_telegram_get_me()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('telegram.me'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['ok' => true]);
    }

    /**
     * A feature test_telegram_send message.
     *
     * @return void
     */
    public function test_telegram_send_message()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('telegram.sendMessage'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['ok' => true]);
    }

    /**
     * A feature test_telegram_get groups.
     *
     * @return void
     */
    public function test_telegram_get_groups()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson(route('telegram.groups'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['ok' => true]);
    }
}
