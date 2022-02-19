<?php

namespace Tests\Feature;

use App\Models\CaptchaToken;
use App\Models\Cases;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\support\Str;

class V1CaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_new_case_with_all_data
     *
     * @return void
     */
    public function test_new_case_with_all_data() : void
    {
        $this->prepareData();

        $token = str_replace(" ", "", microtime().uniqid("", true));
        $captch_key = Str::random(5);
        session($token, $captch_key);

        $captcha_token = new CaptchaToken();
        $captcha_token->token = $token;
        $captcha_token->key = $captch_key;
        $captcha_token->save();

        $wsn = strtoupper(Str::random(8));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            // 'captch_token' => 'hgwfwegfjwegfwegfwefgwuy',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf,twcvea9sfchezkcuqnjp123~sample2.pdf'],
        ]);


        $this->assertEquals(
            $response->baseResponse->original['case']['wsn'],
            $wsn
        );
    }

    /**
     * test_new_case_with_empty_files
     *
     * @return void
     */
    public function test_new_case_with_empty_files() : void
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
            'wsn' => 'KGSGAK82372',
            'files' => [],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['case']['id'],
            Cases::orderby('id', 'DESC')->first()->id
        );
    }

    /**
     * test_new_case_without_wsn
     *
     * @return void
     */
    public function test_new_case_without_wsn() : void
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
            'wsn' => null,
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['case']['id'],
            Cases::orderby('id', 'DESC')->first()->id
        );
    }

    /**
     * test_new_case_without_company_id
     *
     * @return void
     */
    public function test_new_case_without_company_id() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => null,
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_new_case_with_invalid_company_id
     *
     * @return void
     */
    public function test_new_case_with_invalid_company_id() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => 'ABC',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_new_case_with_empty_subject
     *
     * @return void
     */
    public function test_new_case_with_empty_subject() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => '',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_new_case_with_empty_description
     *
     * @return void
     */
    public function test_new_case_with_empty_description() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => null,
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_new_case_without_contact_info
     *
     * @return void
     */
    public function test_new_case_without_contact_info() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => null,
            'wsn' => 'KGSGAK82372',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['case']['id'],
            Cases::orderby('id', 'DESC')->first()->id
        );
    }

    /**
     * test_new_case_with_invalid_token
     *
     * @return void
     */
    public function test_new_case_with_invalid_token() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ehfkjahfkuqwufqhwufqhfukwhqkwdjqwhjdkw',
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => null,
            'wsn' => 'PWDN342392',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Invalid token or company is inactive'
        );
    }

    /**
     * test_new_case_without_token
     *
     * @return void
     */
    public function test_new_case_without_token() : void
    {
        $this->prepareData();

        $response = $this->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => null,
            'wsn' => 'PWDN342392',
            'files' => ['2bidina96aogsvv5lsmr123~sample1.pdf'],
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Invalid token or company is inactive'
        );
    }

    /**
     * test_new_case_without_required_fields
     *
     * @return void
     */
    public function test_new_case_without_required_fields() : void
    {
        $this->prepareData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'description' => 'This is test description',
        ]);

        $this->assertEquals(
            $response->baseResponse->original['case']['id'],
            Cases::orderby('id', 'DESC')->first()->id
        );
    }

    /**
     * test_search_case_with_all_fields
     *
     * @return void
     */
    public function test_search_case_with_all_fields() : void
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.png", 100)
        ]);

        $url = $response->baseResponse->original['path'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => [$url],
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => [$url],
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => [$url],
        ]);

        $case_number = $response->baseResponse->original['case']['case_number'];
        $wsn = $response->baseResponse->original['case']['wsn'];
        $case_id = $response->baseResponse->original['case']['id'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/case-search', [
            'companyid' => '123',
            'case_number' => $case_number,
            'wsn' => $wsn,
        ]);

        $this->assertEquals(
            $response->baseResponse->original['case']['id'],
            $case_id
        );
    }

    /**
     * test_search_case_with_invalid_data
     *
     * @return void
     */
    public function test_search_case_with_invalid_data() : void
    {
        $this->prepareData();

        Company::create(
            [
                'name' => Crypt::encrypt('ABC Begleitung'),
                'token' => 'sjfbvdhi7t27r3tfebacegr3gq3jgryw',
                'wsn' => 'WSN-cn3ui3',
                'phone' => Crypt::encrypt('1234567890'),
                'email' => Crypt::encrypt('abc@gmail.com'),
                'address' => Crypt::encrypt('Friedrichstrasse 6'),
                'city' => Crypt::encrypt('Berlin'),
                'postal_code' => Crypt::encrypt('40221'),
                'note' => Crypt::encrypt('Dies ist eine Testnotiz!'),
                'companyid' => 'ygfhfgjyg3yug3yrqrqr',
            ]
        );

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.png", 100)
        ]);

        $url = $response->baseResponse->original['path'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => 'KGSGAK82372',
            'files' => [$url],
        ]);

        $case_number = $response->baseResponse->original['case']['case_number'];
        $wsn = $response->baseResponse->original['case']['wsn'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/case-search', [
            'companyid' => 'ygfhfgjyg3yug3yrqrqr',
            'case_number' => $case_number,
            'wsn' => $wsn,
        ]);

        $this->assertEquals(
            $response->baseResponse->original['case'],
            false
        );
    }

    /**
     * test_search_case_with_empty_companyid
     *
     * @return void
     */
    public function test_search_case_with_empty_companyid() : void
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
            'wsn' => 'KGSGAK82372',
            'files' => [],
        ]);

        $case_number = $response->baseResponse->original['case']['case_number'];
        $wsn = $response->baseResponse->original['case']['wsn'];
        $case_id = $response->baseResponse->original['case']['id'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/case-search', [
            'companyid' => null,
            'case_number' => $case_number,
            'wsn' => $wsn,
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_search_case_without_companyid
     *
     * @return void
     */
    public function test_search_case_without_companyid() : void
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
            'wsn' => 'KGSGAK82372',
            'files' => [],
        ]);

        $case_number = $response->baseResponse->original['case']['case_number'];
        $wsn = $response->baseResponse->original['case']['wsn'];
        $case_id = $response->baseResponse->original['case']['id'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/case-search', [
            'case_number' => $case_number,
            'wsn' => $wsn,
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_search_case_without_case_number
     *
     * @return void
     */
    public function test_search_case_without_case_number() : void
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
            'wsn' => 'KGSGAK82372',
            'files' => [],
        ]);

        $wsn = $response->baseResponse->original['case']['wsn'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/case-search', [
            'case_number' => null,
            'wsn' => $wsn,
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_search_case_without_wsn
     *
     * @return void
     */
    public function test_search_case_without_wsn() : void
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
            'wsn' => 'KGSGAK82372',
            'files' => [],
        ]);

        $case_number = $response->baseResponse->original['case']['case_number'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/case-search', [
            'case_number' => $case_number,
            'wsn' => null,
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_get_all_cases_for_current_company
     *
     * @return void
     */
    public function test_get_all_cases_for_current_company() : void
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
            'wsn' => 'KGSGAK82372',
            'files' => [],
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/cases', [
            'companyid' => 123,
        ]);

        $this->assertEquals(
            $response->baseResponse->original['success'],
            true
        );
    }

    /**
     * test_get_all_cases_for_current_company_without_company_id
     *
     * @return void
     */
    public function test_get_all_cases_for_current_company_without_company_id() : void
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
            'wsn' => 'KGSGAK82372',
            'files' => [],
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/cases');

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }
}
