<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function email_field_must_be_required()
    {
        $this->postJson('login', array_merge($this->credentials, ["email" => null]))->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_field_must_be_an_email_type()
    {
        $this->postJson('login', array_merge($this->credentials, ["email" => 123]))->assertJsonValidationErrors('email');
    }

    /** @test */
    public function password_field_must_be_required()
    {
        $this->postJson('login', array_merge($this->credentials, ["password" => null]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function password_field_must_be_a_string()
    {
        $this->postJson('login', array_merge($this->credentials, ["password" => 123]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function faild_to_login_with_incorrect_credentials()
    {
        $this->postJson('login', array_merge($this->credentials, ['password' => '12341234']))->assertJsonValidationErrors('email');
    }

    /** @test */
    public function can_user_logged_in_with_thier_account()
    {
        $this->postJson('login', $this->credentials)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('token')->whereType('token', 'string'));
    }
}
