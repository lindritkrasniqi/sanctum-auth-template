<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    private $data = [
        "token" => "token",
        "email" => "lindritkrasniqi@example.com",
        "password" => "new",
        "password_confirmation" => "new",
    ];

    /** @test */
    public function token_is_required()
    {
        $this->postJson('reset', array_merge($this->data, ["token" => null]))->assertJsonValidationErrors('token');
    }

    /** @test */
    public function email_is_required()
    {
        $this->postJson('reset', array_merge($this->data, ["email" => null]))->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_must_be_an_email_type()
    {
        $this->postJson('reset', array_merge($this->data, ["email" => "wrong@email@type"]))->assertJsonValidationErrors('email');
    }

    /** @test */
    public function password_is_required()
    {
        $this->postJson('reset', array_merge($this->data, ['password' => null]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function password_must_be_a_string()
    {
        $this->postJson('reset', array_merge($this->data, ["password" => 12]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function password_must_be_confirmed()
    {
        $this->postJson('reset', array_merge($this->data, ["password" => "123"]))->assertJsonValidationErrors('password');
    }

    /** @test */
    public function user_can_not_reset_thier_password_with_invalid_token()
    {
        $this->postJson('reset', $this->data)->assertJsonValidationErrors('password');
    }

    /** @test */
    public function can_user_reset_thier_password()
    {
        Notification::fake();

        DB::table('password_resets')->insert([
            "token" => bcrypt($this->data['token']),
            "email" => $this->data['email'],
            "created_at" => now()
        ]);

        $this->postJson('reset', $this->data)->assertOk();
    }
}
