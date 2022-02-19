<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_cases
     *
     * @return void
     */
    public function test_cases_for_manager()
    {

        $user = User::create(
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$kfhpGZ.ZSWb16MCPwKpSiOO.YWXGIOd4Z6PqI9ADKgQEojY46y1Eu', // dev@2000
                'remember_token' => 'jhksi74tyw4iykuhefbfseufiw47',
                'role_id' => 1,
                'type' => 'Manager',
                'slug' => 'ZSWB16MCPOWKPSIO',
                'status' => 1
            ]);

        $response = $this->actingAs($user)->get('/manager/cases');

        $response->assertStatus(200);
    }
}
