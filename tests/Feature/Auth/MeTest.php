<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::first());
    }

    /** @test */
    public function can_authenticated_user_fetch_thier_data()
    {
        $this->getJson('me')->assertOk();
    }
}
