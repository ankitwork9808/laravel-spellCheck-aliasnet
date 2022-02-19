<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_upload_file()
    {
        Storage::fake('public');

        $this->json('post', '/file-upload/with_name', [
            'file' => $file = UploadedFile::fake()->image('random.jpg')
        ]);

        $this->assertTrue(true);
    }
}
