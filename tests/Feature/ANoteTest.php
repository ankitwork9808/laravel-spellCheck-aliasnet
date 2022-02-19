<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ANoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_note_store
     *
     * @return void
     */
    public function test_note_store()
    {
        $user = User::factory()->create();
        $company = $this->createCompany(time());
        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$company->token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files[]' => null,
        ]);
        $case_id = $response->baseResponse->original['case']->id;
        $response = $this->actingAs($user)->post('/admin/notes-store', [
            'case_id' => $case_id,
            'note' => 'This is test note',
            'is_private' => 1,
        ]);
        $this->assertEquals($response->baseResponse->original[0]['case_id'], $case_id);
    }

    /**
     * test_update_category
     *
     * @return void
     */
    public function test_update_category()
    {
        $user = User::factory()->create();
        $company = $this->createCompany(time());
        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$company->token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files[]' => null,
        ]);

        $case_id = $response->baseResponse->original['case']->id;
        $response = $this->actingAs($user)->post('/admin/notes-category', [
            'case_id' => $case_id,
            'category_id' => 2,
        ]);

        $response->assertStatus(200);

        $user->type = 'Manager';
        $user->save();
        $response = $this->actingAs($user)->post('/manager/notes-category', [
            'case_id' => $case_id,
            'category_id' => 2,
        ]);

        $response->assertStatus(200);
    }
}
