<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\FileToken;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Str;

class FileUrlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_get_file_url
     *
     * @return void
     */
    public function test_get_file_url() : void
    {
        $this->prepareData();
        Storage::fake('library');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.png", 100)
        ]);

        $url = $response->baseResponse->original['path'];

        $wsn = strtoupper(Str::random(8));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => [$url],
        ]);

        $file = File::first();

        $file_token = new FileToken();
        $file_token->file_id = $file->id;
        $file_token->token = Str::random(50);
        $file_token->expire_in =  Carbon::now()->addMinutes(config('app.file_url_expire_in'));
        $file_token->save();

        $response = $this->get('/file-url/'.$file_token->token);
        $response->assertStatus(200);
    }

    /**
     * test_expired_get_file_url
     *
     * @return void
     */
    public function test_expired_get_file_url() : void
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.png", 100)
        ]);

        $url = $response->baseResponse->original['path'];

        $wsn = strtoupper(Str::random(8));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/create-case', [
            'companyid' => '123',
            'subject' => 'This is test subject',
            'category_id' => '1',
            'description' => 'This is test description',
            'contact_info' => '9876543210',
            'wsn' => $wsn,
            'files' => [$url],
        ]);

        $file = File::first();

        $file_token = new FileToken();
        $file_token->file_id = $file->id;
        $file_token->token = Str::random(50);
        $file_token->expire_in =  Carbon::now()->subMinute(config('app.file_url_expire_in'));
        $file_token->save();

        $response = $this->get('/file-url/'.$file_token->token);

        $this->assertEquals($response->baseResponse->original, 'Die Dateisitzung ist abgelaufen.');
    }
}
