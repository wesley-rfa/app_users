<?php

namespace Tests\Feature\App;

use Tests\TestCase;

class UserApiResourceTest extends TestCase
{
    private $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    private $route = '/api/users';

    public function testSuccessfulIndexMethod()
    {
        $response = $this->withHeaders($this->headers)->get($this->route);
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'createdAt',
                    'updatedAt'
                ]
            ],
            'meta' => [
                'apiVersion'
            ]
        ]);
    }

    public function testBadRequestOnStoreMethod(): void
    {
        $response = $this->withHeaders($this->headers)->post($this->route, [
            'name' => '',
            'email' => '',
            'password' => '',
            'passwordConfirmation' => ''
        ]);

        $response->assertStatus(400);
    }
}
