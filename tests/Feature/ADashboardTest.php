<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ADashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_a_dashboard_with_admin_user
     *
     * @return void
     */
    public function test_a_dashboard_with_admin_user() : void
    {

        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => '',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf,twcvea9sfchezkcuqnjp123~sample2.pdf'],
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    /**
     * test_a_dashboard_with_manager_user
     *
     * @return void
     */
    public function test_a_dashboard_with_manager_user() : void
    {

        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->save();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(302);
    }

    /**
     * test_a_dashboard_with_user
     *
     * @return void
     */
    public function test_a_dashboard_with_user() : void
    {

        $user = User::factory()->create();
        $user->type = 'User';
        $user->save();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(302);
    }
}
