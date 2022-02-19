<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{

    use RefreshDatabase;

    /**
     * test_dashboard_with_admin_user
     *
     * @return void
     */
    public function test_dashboard_with_admin_user() : void
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(302);
    }

    /**
     * test_dashboard_with_manager_user
     *
     * @return void
     */
    public function test_dashboard_with_manager_user() : void
    {

        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->save();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(302);
    }

    /**
     * test_dashboard_with_user
     *
     * @return void
     */
    public function test_dashboard_with_user() : void
    {

        $user = User::factory()->create();
        $user->type = 'User';
        $user->save();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }
}
