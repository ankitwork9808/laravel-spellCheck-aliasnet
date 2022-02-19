<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ACaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_soft_delete()
    {
        $user = User::factory()->create();
        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => 'ABC Begleitung',
                'token' => $token,
                'phone' => '1234567890',
                'email' => 'abc@gmail.com',
                'address' => 'Friedrichstrasse 6',
                'city' => 'Berlin',
                'state_id' => null,
                'country_id' => null,
                'postal_code' => '40221',
                'note' => 'Dies ist eine Testnotiz!'
            ]
        );

        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '',
        ]);
        $response = $this->actingAs($user)->post('/admin/soft-delete/'.$response->baseResponse->original['case']['id']);
        $response->assertStatus(200);
    }

    /**
     * test_soft_delete_with_wrong_id
     *
     * @return void
     */
    public function test_soft_delete_with_wrong_id()
    {
        $user = User::factory()->create();
        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => 'ABC Begleitung',
                'token' => $token,
                'phone' => '1234567890',
                'email' => 'abc@gmail.com',
                'address' => 'Friedrichstrasse 6',
                'city' => 'Berlin',
                'state_id' => null,
                'country_id' => null,
                'postal_code' => '40221',
                'note' => 'Dies ist eine Testnotiz!'
            ]
        );

        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '',
        ]);
        $response = $this->actingAs($user)->post('/admin/soft-delete/3');
        $response->assertStatus(200);
    }

    /**
     * test_restore
     *
     * @return void
     */
    public function test_restore()
    {
        $user = User::factory()->create();
        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => 'ABC Begleitung',
                'token' => $token,
                'phone' => '1234567890',
                'email' => 'abc@gmail.com',
                'address' => 'Friedrichstrasse 6',
                'city' => 'Berlin',
                'state_id' => null,
                'country_id' => null,
                'postal_code' => '40221',
                'note' => 'Dies ist eine Testnotiz!'
            ]
        );

        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '',
        ]);
        $this->actingAs($user)->post('/admin/soft-delete/'.$response->baseResponse->original['case']['id']);
        $this->actingAs($user)->post('/admin/case-restore/'.$response->baseResponse->original['case']['id']);
        $response->assertStatus(201);
    }

    /**
     * test_soft_delete_as_manager
     *
     * @return void
     */
    public function test_soft_delete_as_manager()
    {
        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->save();
        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => 'ABC Begleitung',
                'token' => $token,
                'phone' => '1234567890',
                'email' => 'abc@gmail.com',
                'address' => 'Friedrichstrasse 6',
                'city' => 'Berlin',
                'state_id' => null,
                'country_id' => null,
                'postal_code' => '40221',
                'note' => 'Dies ist eine Testnotiz!'
            ]
        );

        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '',
        ]);
        $response = $this->actingAs($user)->post('/manager/soft-delete/'.$response->baseResponse->original['case']['id']);
        $response->assertStatus(200);
    }

    /**
     * test_soft_delete_with_wrong_id_as_manager
     *
     * @return void
     */
    public function test_soft_delete_with_wrong_id_as_manager()
    {
        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->save();
        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => 'ABC Begleitung',
                'token' => $token,
                'phone' => '1234567890',
                'email' => 'abc@gmail.com',
                'address' => 'Friedrichstrasse 6',
                'city' => 'Berlin',
                'state_id' => null,
                'country_id' => null,
                'postal_code' => '40221',
                'note' => 'Dies ist eine Testnotiz!'
            ]
        );

        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '',
        ]);
        $response = $this->actingAs($user)->post('/manager/soft-delete/3');
        $response->assertStatus(200);
    }

    /**
     * test_restore_as_manager
     *
     * @return void
     */
    public function test_restore_as_manager()
    {
        $user = User::factory()->create();
        $user->type = 'Manager';
        $user->save();
        $token = 'bDKiKqyC5VTOmQZIpcZM2p7vEkKdCsDE30sAuqe7eY9cxUpHgRz7c6fDvpwoL21amyG2ZrF2V12r8ijxr1wjRCgKaQpfDlMh2FLz';
        $company = Company::create(
            [
                'companyid' => 12338274,
                'name' => 'ABC Begleitung',
                'token' => $token,
                'phone' => '1234567890',
                'email' => 'abc@gmail.com',
                'address' => 'Friedrichstrasse 6',
                'city' => 'Berlin',
                'state_id' => null,
                'country_id' => null,
                'postal_code' => '40221',
                'note' => 'Dies ist eine Testnotiz!'
            ]
        );

        Status::insert([
            [
                'name' => 'Eingereicht',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Bearbeitung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Abgeschlossen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $wsn = 'DJAS73434';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/V1/create-case', [
            'companyid' => $company->companyid,
            'subject' => 'This is test subject',
            'category_id' => '',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => '',
        ]);
        $this->actingAs($user)->post('/manager/soft-delete/'.$response->baseResponse->original['case']['id']);
        $this->actingAs($user)->post('/manager/case-restore/'.$response->baseResponse->original['case']['id']);
        $response->assertStatus(201);
    }
}
