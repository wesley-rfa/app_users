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

    public function testBadRequestOnStore(): void
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
