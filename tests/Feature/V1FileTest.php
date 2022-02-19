<?php

namespace Tests\Feature;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class V1FileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_upload_attachment_with_pdf
     *
     * @return void
     */
    public function test_upload_attachment_with_pdf()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.pdf", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_doc
     *
     * @return void
     */
    public function test_upload_attachment_with_doc()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.doc", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_docx
     *
     * @return void
     */
    public function test_upload_attachment_with_docx()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.docx", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_xls
     *
     * @return void
     */
    public function test_upload_attachment_with_xls()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.xls", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_xlsx
     *
     * @return void
     */
    public function test_upload_attachment_with_xlsx()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.xlsx", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_csv
     *
     * @return void
     */
    public function test_upload_attachment_with_csv()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.csv", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_txt
     *
     * @return void
     */
    public function test_upload_attachment_with_txt()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.txt", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_png
     *
     * @return void
     */
    public function test_upload_attachment_with_png()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.png", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_jpg
     *
     * @return void
     */
    public function test_upload_attachment_with_jpg()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.jpg", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_jpeg
     *
     * @return void
     */
    public function test_upload_attachment_with_jpeg()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.jpeg", 100)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['name'],
            'test'
        );
    }

    /**
     * test_upload_attachment_with_large_size
     *
     * @return void
     */
    public function test_upload_attachment_with_large_size()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.jpeg", 60000)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_upload_attachment_with_invalid_format
     *
     * @return void
     */
    public function test_upload_attachment_with_invalid_format()
    {
        $this->prepareData();

        Storage::fake('library');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/upload-file', [
            'file' => UploadedFile::fake()->create("test.gif", 10000)
        ]);

        $this->assertEquals(
            $response->baseResponse->original['message'],
            'Validation errors'
        );
    }

    /**
     * test_delete_file
     *
     * @return void
     */
    public function test_delete_file() : void
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
        ])->post('/api/V1/delete-file', [
            'url' => $url
        ]);

        $this->assertEquals(
                $response->baseResponse->original['success'],
                true
            );
    }

    /**
     * test_delete_file_with_invalid_url
     *
     * @return void
     */
    public function test_delete_file_with_invalid_url() : void
    {
        $this->prepareData();

        $url = 'http://127.0.0.1:8000/storage/ex6nomuqzsroe9gqh5zt123~test.png';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/delete-file', [
            'url' => $url
        ]);

        $this->assertEquals(
                $response->baseResponse->original['success'],
                false
            );
    }

    /**
     * test_delete_file_with_empty_url
     *
     * @return void
     */
    public function test_delete_file_with_empty_url() : void
    {
        $this->prepareData();

        $url = '';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/delete-file', [
            'url' => $url
        ]);

        $this->assertEquals(
                $response->baseResponse->original['message'],
                'Validation errors'
            );
    }

    /**
     * test_delete_file_with_use
     *
     * @return void
     */
    public function test_delete_file_with_use() : void
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
            'files' => '',
        ]);

        File::create([
            'case_id' => $response->baseResponse->original['case']['id'],
            'file_path' => $url,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->post('/api/V1/delete-file', [
            'url' => $url
        ]);

        $this->assertEquals(
                $response->baseResponse->original['success'],
                false
            );
    }
}
