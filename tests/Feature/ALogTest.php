<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ALogTest extends TestCase
{
    use RefreshDatabase;
    /**
     * test_get_logs
     *
     * @return void
     */
    public function test_get_logs()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/bugs');

        $response->assertStatus(200);
    }
}
