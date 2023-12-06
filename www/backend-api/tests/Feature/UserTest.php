<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Check validation
     */
    public function test_AuthValidateEmail(): void
    {

        # Test #1
        # TEST FIELD EMAIL DOESN'T EXIST
        $response = $this->postJson('/api/auth',[
            "login" => "test",
            "password" => "12345678"
        ]);
        $responseArray = json_decode($response->content());
        $this->assertSame("error", $responseArray->status);
        $this->assertSame("Email обязательное поле", $responseArray->data->email[0]);
        $this->assertTrue(count($responseArray->data->email) > 0);

        $response->assertStatus(422);


        # Test #2
        # TEST FIELD EMAIL EXIST BUT INCORRECT
        $response = $this->postJson('/api/auth',[
            "email" => "test",
            "password" => "12345678"
        ]);

        $responseArray = json_decode($response->content());
        $emailValidationError = "";
        if(count($responseArray->data->email) > 0) {
            $emailValidationError = array_shift($responseArray->data->email);
        }
        $this->assertSame("Email - неверный формат", $emailValidationError);
    }

}
