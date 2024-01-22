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

    public function testValidationOnStoreMethod(): void
    {
        $response = $this->withHeaders($this->headers)->postJson($this->route, [
            'name' => '',
            'email' => '',
            'password' => '',
            'passwordConfirmation' => ''
        ]);

        $response->assertStatus(400)->assertJsonFragment(['errorCode' => 1]);
    }

    public function testSuccessfulCreateUser()
    {
        $response = $this->withHeaders($this->headers)->postJson($this->route, [
            'name' => 'Wesley Ribeiro',
            'email' => 'wesley_ribeirof@outlook.com',
            'password' => '123456',
            'passwordConfirmation' => '123456'
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'name',
                'email',
                'createdAt',
                'updatedAt'
            ],
            'meta' => [
                'apiVersion'
            ]
        ]);
    }

    public function testNameValidationOnCreateUser()
    {
        $response = $this->withHeaders($this->headers)->postJson($this->route, [
            'name' => '',
            'email' => 'wesley_ribeirof@outlook.com',
            'password' => '123456',
            'passwordConfirmation' => '123456'
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'success',
            'data' => [
                'errorCode',
                'errorMessage',
                'errorList' => [
                    'name'
                ]
            ],
            'meta' => [
                'apiVersion'
            ]
        ]);
    }

    public function testEmailValidationOnCreateUser()
    {
        $response = $this->withHeaders($this->headers)->postJson($this->route, [
            'name' => 'Wesley Ribeiro',
            'email' => 'wesley_ribeirof',
            'password' => '123456',
            'passwordConfirmation' => '123456'
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            'success',
            'data' => [
                'errorCode',
                'errorMessage',
                'errorList' => [
                    'email'
                ]
            ],
            'meta' => [
                'apiVersion'
            ]
        ]);
    }

    public function testPasswordValidationOnCreateUser()
    {
        $response = $this->withHeaders($this->headers)->postJson($this->route, [
            'name' => 'Wesley Ribeiro',
            'email' => 'wesley_ribeirof@outlook.com',
            'password' => '',
            'passwordConfirmation' => '123456'
        ]);

        $response->dump();

        $response->assertStatus(400)->assertJsonStructure([
            'success',
            'data' => [
                'errorCode',
                'errorMessage',
                'errorList' => [
                    'password',
                    'passwordConfirmation',
                ]
            ],
            'meta' => [
                'apiVersion'
            ]
        ]);
    }
}
