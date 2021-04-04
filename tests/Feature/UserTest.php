<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A test index
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }

    /**
     * test show
     *
     * @return void
     */
    public function testShow()
    {
        $user = User::first();
        $response = $this->get('/api/users/' . $user->id);
        $response->assertStatus(200);
        $this->assertEquals($user->id, json_decode($response->content(), TRUE)['id']);
    }

    /**
     * test store
     *
     * @return void
     */
    public function testStore()
    {
        $response = $this->post('/api/users', [
            "name" => "jimbo999",
            "email" => "jimb99o@het.com",
            "password" => "test123"
        ]);

        $this->assertEquals('jimbo999', json_decode($response->content(), TRUE)['name']);
    }

    /**
     * test update
     *
     * @return void
     */
    public function testUpdate()
    {
        $response = $this->post('/api/users', [
            "name" => "jimbo999",
            "email" => "jimb99o@het.com",
            "password" => "test123"
        ]);

        $responseUser = json_decode($response->content(), TRUE);
        $this->assertEquals('jimbo999', $responseUser['name']);

        $headers = [
            'Authorization' => 'Bearer ' . $responseUser['token']
        ];

        $responseUpdate = $this->withHeaders($headers)
            ->post('/api/users/' . $responseUser['id'], [
                "name" => "jimbo9992",
            ]
        );
        $response->assertStatus(200);
    }
}
