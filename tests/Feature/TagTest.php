<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class TasgTest extends TestCase
{
    /**
     * test index
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/tags');
        $response->assertStatus(200);
    }

    /**
     * test show
     *
     * @return void
     */
    public function testShow()
    {
        $tag = Tag::first();
        $response = $this->get('/api/tags/' . $tag->id);
        $response->assertStatus(200);
        $this->assertEquals($tag->id, json_decode($response->content(), TRUE)['id']);
    }

    /**
     * test store
     *
     * @return void
     */
    public function testStore()
    {
        $response = $this->post('/api/tags', [
            "name" => "Lorem Ipsum",
        ]);
        $this->assertEquals('Lorem Ipsum', json_decode($response->content(), TRUE)['name']);
    }

    /**
     * test update
     *
     * @return void
     */
    public function testUpdate()
    {
        $response = $this->post('/api/tags', [
            "name" => "test",
        ]);

        $responseFile = json_decode($response->content(), TRUE);
        $this->assertEquals('test', $responseFile['name']);

        $headers = [
            'Authorization' => 'Bearer ' . $responseFile['token']
        ];

        $responseUpdate = $this->withHeaders($headers)
            ->post('/api/tags/' . $responseFile['id'], [
                "name" => "test2",
            ]
        );
        $response->assertStatus(200);
    }

    /**
     * test destroy
     *
     * @return void
     */
    public function testDelete()
    {
        $response = $this->delete('/api/tags/' . Tag::first()->id);
        $response->assertStatus(200);
    }
}
