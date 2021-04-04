<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A test index
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/files');
        $response->assertStatus(200);
    }

    /**
     * test show
     *
     * @return void
     */
    public function testShow()
    {
        $file = File::first();
        $response = $this->get('/api/files/' . $file->id);
        $response->assertStatus(200);
        $this->assertEquals($file->id, json_decode($response->content(), TRUE)['id']);
    }

    /**
     * test store
     *
     * @return void
     */
    public function testStore()
    {
        $response = $this->post('/api/files', [
            "data" => "Lorem Ipsum",
        ]);
        $this->assertEquals('Lorem Ipsum', json_decode($response->content(), TRUE)['data']);
    }

    /**
     * test destroy
     *
     * @return void
     */
    public function testDelete()
    {
        $response = $this->delete('/api/files/' . File::first()->id);
        $response->assertStatus(200);
    }
}
