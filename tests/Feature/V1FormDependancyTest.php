<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class V1FormDependencyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_form_dependency
     *
     * @return void
     */
    public function test_form_dependency() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->get('api/V1/form-dependency?captch_status=676387263873');

        $this->assertEquals(
            $response->baseResponse->original['dependency']['categories'][1],
            Category::first()->name
        );
    }

    public function test_get_packages() : void
    {
        $this->prepareData();

        Package::insert([
            [
                'name' => Crypt::encrypt('1st level'),
                'employees' => Crypt::encrypt('15 mitareiter'),
                'amount' => Crypt::encrypt(15),
                'time_period' => 'Monthly',
                'currency_symbol' => Crypt::encrypt('€'),
                'currency_name' => Crypt::encrypt('Euro'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->get('api/V1/get-packages');

        $this->assertEquals(
            $response->baseResponse->original['success'],
            true
        );
    }

    /**
     * test_form_dependency_with_invalid_token
     *
     * @return void
     */
    public function test_form_dependency_with_invalid_token() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer fkkjfhjsdhfkjwe',
        ])->get('api/V1/form-dependency');

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Invalid token or company is inactive'
        );
    }

    /**
     * test_form_dependency_without_token
     *
     * @return void
     */
    public function test_form_dependency_without_token() : void
    {
        $this->prepareData();

        $response = $this->get('api/V1/form-dependency');

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Invalid token or company is inactive'
        );
    }
}
