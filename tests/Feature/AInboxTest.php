<?php

namespace Tests\Feature;

use App\Models\Cases;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AInboxTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_inbox
     *
     * @return void
     */
    public function test_inbox()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/inbox');
        $response->assertStatus(200);
    }

    /**
     * test_cases
     *
     * @return void
     */
    public function test_cases_for_inbox()
    {
        $this->prepareData();
        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.pdf", 100)
        ]);

        $file = $response->baseResponse->original['path'];
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
            'files' => [$file],
        ]);

        $response = $this->actingAs($user)->post('/admin/cases/'.$company->id);
        $this->assertEquals($response->baseResponse->original[0]['wsn'], $wsn);
    }

    /**
     * test_update_case_count
     *
     * @return void
     */
    public function test_update_case_count()
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
            'files' => [],
        ]);

        $response = $this->actingAs($user)->get('/admin/update-case-count/1');
        $this->assertEquals($response->baseResponse->original, 0);
        $user->type = 'Manager';
        $user->save();
        $response = $this->actingAs($user)->get('/manager/update-case-count/1');
        $this->assertEquals($response->baseResponse->original, 0);
    }

    /**
     * test_get_managers
     *
     * @return void
     */
    public function test_get_managers()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/manager-list/1');
        $response->assertStatus(200);
        $user->type = 'Manager';
        $user->save();
        $response = $this->actingAs($user)->get('/manager/manager-list/1');
        $response->assertStatus(200);
    }

    /**
     * test_update_case_manager
     *
     * @return void
     */
    public function test_update_case_manager()
    {
        $user = User::factory()->create();
        $company = $this->createCompany(time());
        $wsn = 'DJAS73434';

        $this->withHeaders([
            'Authorization' => 'Bearer '.$company->token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => [],
        ]);
        $response = $this->actingAs($user)->post('/admin/case-manager', [
            'manager_id' => 1,
            'case_id' => 1,
        ]);

        $this->assertEquals($response->baseResponse->original['user_id'], 1);
        $user->type = 'Manager';
        $user->save();
        $response = $this->actingAs($user)->post('/manager/case-manager', [
            'manager_id' => 1,
            'case_id' => 1,
        ]);
        $this->assertEquals($response->baseResponse->original['user_id'], 1);
    }

    /**
     * test_company_search
     *
     * @return void
     */
    public function test_company_search()
    {
        $token = time();
        $user = User::factory()->create();
        $this->createCompany($token);
        $response = $this->actingAs($user)->post('/admin/company-search', [
            'keyword' => 'ABC',
        ]);
        $this->assertEquals($response->baseResponse->original[0]['token'], $token);
    }

    /**
     * test_company_search_with_unknown_keyword
     *
     * @return void
     */
    public function test_company_search_with_unknown_keyword()
    {
        $user = User::factory()->create();
        $this->createCompany(time());

        $response = $this->actingAs($user)->post('/admin/company-search', [
            'keyword' => 'ABCD',
        ]);
        $response->assertStatus(200);
    }

    /**
     * test_cases_with_status
     *
     * @return void
     */
    public function test_cases_with_status()
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
            'files' => [],
        ]);

        $response = $this->actingAs($user)->post('/admin/cases/1', [
            'status_id' => 'archived',
            'overdue' => '',
            'case_id' => '',
        ]);
        $this->assertEquals($response->baseResponse->original['total'], false);
    }

    /**
     * test_cases_with_status_id
     *
     * @return void
     */
    public function test_cases_with_status_id()
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
            'files' => [],
        ]);

        $response = $this->actingAs($user)->post('/admin/cases/1', [
            'status_id' => '1',
            'overdue' => '',
            'case_id' => '',
        ]);
        $this->assertEquals($response->baseResponse->original['total'], false);
    }

    /**
     * test_cases_with_case_id
     *
     * @return void
     */
    public function test_cases_with_case_id()
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
            'files' => [],
        ]);

        $response = $this->actingAs($user)->post('/admin/cases/1', [
            'status_id' => '',
            'overdue' => '',
            'case_id' => '36742637846237',
        ]);
        $this->assertEquals($response->baseResponse->original['total'], false);
    }

    /**
     * test_cases_with_all_overdue
     *
     * @return void
     */
    public function test_cases_with_all_overdue()
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
            'files' => [],
        ]);

        $response = $this->actingAs($user)->post('/admin/cases/1', [
            'status_id' => '',
            'overdue' => '0',
            'case_id' => '',
        ]);
        $this->assertEquals($response->baseResponse->original['total'], false);

        $user->type = 'Manager';
        $user->save();
        $response = $this->actingAs($user)->post('/manager/cases/1', [
            'status_id' => '',
            'overdue' => '0',
            'case_id' => '',
        ]);
        $this->assertEquals($response->baseResponse->original['total'], false);
    }

    /**
     * test_cases_with_1_day_overdue
     *
     * @return void
     */
    public function test_cases_with_1_day_overdue()
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
            'files' => [],
        ]);

        $response = $this->actingAs($user)->post('/admin/cases/1', [
            'status_id' => '',
            'overdue' => '2',
            'case_id' => '',
        ]);
        $this->assertEquals($response->baseResponse->original['total'], false);
    }

    /**
     * test_case_detail
     *
     * @return void
     */
    public function test_case_detail()
    {
        $user = User::factory()->create();
        $random_str = time();
        $company = $this->createCompany($random_str);
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
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf,twcvea9sfchezkcuqnjp123~sample2.pdf'],
        ]);

        $case_number = $response->baseResponse->original['case']['case_number'];
        $response = $this->actingAs($user)->get('/admin/case-detail/'.$case_number);
        $this->assertEquals($response->baseResponse->original['subject'], 'This is test subject');


        Cases::where('id', $response->baseResponse->original['id'])->update([
            'user_id' => $user->id
        ]);

        $user->type = 'Manager';
        $user->save();
        $response = $this->actingAs($user)->get('/manager/case-detail/'.$case_number);
        $this->assertEquals($response->baseResponse->original['subject'], 'This is test subject');
    }

    /**
     * test_update_case_status
     *
     * @return void
     */
    public function test_update_case_status()
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
            'files' => [],
        ]);

        $response = $this->actingAs($user)->post('/admin/case-status', [
            'status_id' => 1,
            'case_id' => $response->baseResponse->original['case']['id']
        ]);
        $this->assertEquals($response->baseResponse->original['status_id'], 1);
        $user->type = 'Manager';
        $user->save();

        Cases::where('id', $response->baseResponse->original['id'])->update([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->post('/manager/case-status', [
            'status_id' => 1,
            'case_id' => $response->baseResponse->original['id']
        ]);
        $this->assertEquals($response->baseResponse->original['status_id'], 1);
    }
}