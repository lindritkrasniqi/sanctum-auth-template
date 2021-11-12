<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    private $user = [
        "name" => "Lindrit Krasniqi",
        "email" => "test@example.com",
        "password" => "secret",
        "password_confirmation" => "secret",
    ];

    /** @test */
    public function name_field_is_required()
    {
        $this->postJson('register', array_merge($this->user, ['name' => null]))->assertJsonValidationErrors('name');
    }

    /** @test */
    public function name_field_must_be_a_string()
    {
        $this->postJson('register', array_merge($this->user, ['name' => 12]))->assertJsonValidationErrors('name');
    }

    /** @test */
    public function email_field_is_required()
    {
        $this->postJson('register', array_merge($this->user, ['email' => null]))->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_field_must_be_unique_on_users()
    {
        $this->postJson('register', array_merge($this->user, ['email' => 'lindritkrasniqi@example.com']))->assertJsonValidationErrors('email');
    }

    /** @test */
    public function password_field_is_required()
    {
        $this->postJson('register', array_merge($this->user, ['password' => null]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function password_field_must_be_a_string()
    {
        $this->postJson('register', array_merge($this->user, ["password" => 12]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function password_field_must_be_confirmed()
    {
        $this->postJson('register', array_merge($this->user, ["password" => "123"]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function can_user_be_registered()
    {
        $this->postJson('register', $this->user)->assertCreated();
    }
}
