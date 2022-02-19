<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_list_by_country_id
     *
     * @return void
     */
    public function test_list_by_country_id()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/state-list/1');

        $response->assertStatus(200);
    }
}
