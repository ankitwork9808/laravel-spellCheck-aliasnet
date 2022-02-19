<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_index_with_admin_user_type
     *
     * @return void
     */
    public function test_index_with_admin_user_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertStatus(200);
    }

    /**
     * test_index_with_detector_user_type
     *
     * @return void
     */
    public function test_index_with_detector_user_type()
    {
        $user = User::factory()->create();
        $user->type = 'Detector';
        $user->save();

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertStatus(200);
    }

    /**
     * test_index_with_manager_user_type
     *
     * @return void
     */
    public function test_index_with_manager_user_type()
    {
        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->save();

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertStatus(302);
    }

    /**
     * test_create_with_admin_user_type
     *
     * @return void
     */
    public function test_create_with_admin_user_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users/create');

        $response->assertStatus(200);
    }

    /**
     * test_edit_with_admin_user_type
     *
     * @return void
     */
    public function test_edit_with_admin_user_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users/'.$user->slug.'/edit');

        $response->assertStatus(200);
    }

    /**
     * test_store_with_admin_user_type
     *
     * @return void
     */
    public function test_store_with_admin_user_type()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
                        ->post('admin/users', [
                            'name' => 'Test User',
                            'email' => 'test@unittest.com',
                            'password' => 'dev@2000',
                            'password_confirmation' => 'dev@2000',
                            'role_id' => '1',
                            'status' => '1',
                            'company_id' => null,
                            'type' => 'Admin'
                        ]);

        $new_user = User::where('email', 'test@unittest.com')->first();
        $this->assertEquals($new_user->email, 'test@unittest.com');
    }

    /**
     * test_store_wrong_data
     *
     * @return void
     */
    public function test_store_wrong_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('admin/users', [
                            'name' => 'Test User',
                            'email' => 'test@unittest.com',
                            'password' => 'dev@2000',
                            'password_confirmation' => 'dev@2000',
                            'role_id' => '1',
                            'status' => '1',
                            'company_id' => null,
                            'types' => 'Admin'
                        ]);

        $response->assertStatus(302);
    }

    /**
     * test_update_with_admin_user_type
     *
     * @return void
     */
    public function test_update_with_admin_user_type()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
                        ->put('admin/users/'.$user->slug, [
                            'name' => 'XYZ',
                            'email' => 'xyz@unittest.com',
                            'password' => 'dev@2000',
                            'password_confirmation' => 'dev@2000',
                            'role_id' => '1',
                            'status' => '1',
                            'company_id' => null,
                            'type' => 'Admin'
                        ]);

        $new_user = User::where('email', 'xyz@unittest.com')->first();
        $this->assertEquals($new_user->name, 'XYZ');
    }

    /**
     * test_destroy_with_admin_user_type
     *
     * @return void
     */
    public function test_destroy_with_admin_user_type()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
                        ->post('admin/users', [
                            'name' => 'Test User',
                            'email' => 'test@unittest.com',
                            'password' => 'dev@2000',
                            'password_confirmation' => 'dev@2000',
                            'role_id' => '1',
                            'status' => '1',
                            'company_id' => null,
                            'type' => 'Admin'
                        ]);

        $new_user = User::where('email', 'test@unittest.com')->first();
        $response = $this->actingAs($user)->delete('admin/users/'.$new_user->id);
        $response->assertStatus(200);
    }

    /**
     * test_search_with_admin_user_type
     *
     * @return void
     */
    public function test_search_with_admin_user_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('admin/users-search', [
                            'type' => 'Admin',
                            'keyword' => 'Super Admin',
                        ]);

        $response->assertStatus(200);
    }

    /**
     * test_search_with_empty_type
     *
     * @return void
     */
    public function test_search_with_empty_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('admin/users-search', [
                            'type' => null,
                            'keyword' => 'Super Admin',
                        ]);

        $response->assertStatus(200);
    }

    /**
     * test_search_with_admin_user_keyword
     *
     * @return void
     */
    public function test_search_with_admin_user_keyword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('admin/users-search', [
                            'type' => 'Admin',
                            'keyword' => null,
                        ]);

        $response->assertStatus(200);
    }

    /**
     * test_update_user_status
     *
     * @return void
     */
    public function test_update_user_status()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('admin/user-status', [
                            'id' => 1,
                            'status' => 1,
                        ]);

        $response->assertStatus(200);
    }
}
