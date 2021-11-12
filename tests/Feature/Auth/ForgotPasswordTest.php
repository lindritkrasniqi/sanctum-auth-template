<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /** @test */
    public function email_must_be_required()
    {
        $this->postJson('forgot', ["email" => null])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_must_be_checked_if_exists_on_users_table_first()
    {
        $this->postJson('forgot', ["email" => "test@test.com"])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function does_user_recieve_a_reset_password_link()
    {
        Notification::fake();

        $this->postJson('forgot', $this->credentials)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('message')->whereType('message', 'string'));
    }
}
