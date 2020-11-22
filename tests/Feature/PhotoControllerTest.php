<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoControllerTest extends TestCase
{
    /**
     * Index test.
     *
     * @return void
     */
    public function testIndex()
    {
        //creating a file to test index
        $fileName = 'public/storage/uploads/images/testfile.jpg';
        $testFile = fopen($fileName, 'w');
        $testData = "img";
        fwrite($testFile, $testData);
        //url test
        $response = $this->get('/');
        $response->assertStatus(200);
        $content = $response->content();
        //checking if view has test file
        $this->assertStringContainsString('testfile.jpg', $content);

        unlink($fileName);
    }
    
    /**
     * Store from api test.
     *
     * @return void
     */
    public function testStore()
    {
        
        //creating a file to test
        $fileName = 'testfile.jpg';
        $testFile = fopen($fileName, 'w');
        $testData = "img";
        $date = '22-02-2020';
        fwrite($testFile, $testData);
        $file = new UploadedFile($fileName, $fileName, 'image/png', filesize($fileName), true);
        $response = $this->call('POST', 'photos/store', ['_token' => csrf_token(), 'date' => $date], [], ['image' => $file], []);
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/');
        
        unlink($fileName);
    }
    
    /**
     * Store from api test.
     *
     * @return void
     */
    public function testApiStore()
    {
        //creating a file to test
        $fileName = 'test.jpg';
        $testFile = fopen($fileName, 'w');
        $testData = "img";
        $date = '22-02-2020';
        fwrite($testFile, $testData);
        $response = $this->get('/api/photos/store?url='.$fileName.'&date='.$date);
        $this->assertStringContainsString('success', $response->content());
        //passing wrong parameters
        $wrongDateFormat = '2020-02-02';
        $response = $this->get('/api/photos/store?url='.$fileName.'&date='.$wrongDateFormat);
        $this->assertStringContainsString('error', $response->content());
        $wrongFileName = 'test.pdf';
        $response = $this->get('/api/photos/store?url='.$wrongFileName.'&date='.$date);
        $this->assertStringContainsString('error', $response->content());
        
        unlink($fileName);
    }
}
