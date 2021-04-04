<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A test index
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200);
    }

    /**
     * test show
     *
     * @return void
     */
    public function testShow()
    {
        $post = Post::first();
        $response = $this->get('/api/posts/' . $post->id);
        $response->assertStatus(200);
        $this->assertEquals($post->id, json_decode($response->content(), TRUE)['id']);
    }

    /**
     * test store
     *
     * @return void
     */
    public function testStore()
    {
        $response = $this->post('/api/posts', [
            "title" => "test",
            "body" => "here is a body",
            "owner" => User::first()->id,
            "main_image" => File::first()->id
        ]);
        $this->assertEquals('test', json_decode($response->content(), TRUE)['title']);
    }

    /**
     * test update
     *
     * @return void
     */
    public function testUpdate()
    {
        $response = $this->post('/api/posts', [
            "title" => "test",
            "body" => "here is a body",
            "owner" => User::first()->id,
            "main_image" => File::first()->id
        ]);

        $responseUser = json_decode($response->content(), TRUE);
        $this->assertEquals('test', $responseUser['title']);

        $headers = [
            'Authorization' => 'Bearer ' . $responseUser['token']
        ];

        $responseUpdate = $this->withHeaders($headers)
            ->post('/api/posts/' . $responseUser['id'], [
                "title" => "test2",
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
        $response = $this->delete('/api/posts/' . Post::first()->id);
        $response->assertStatus(200);
    }
}
