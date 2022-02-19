<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConnectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_connection()
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->get('api/V1/connection');

        $this->assertEquals(
                $response->baseResponse->original['success'],
                true
            );
    }
}
