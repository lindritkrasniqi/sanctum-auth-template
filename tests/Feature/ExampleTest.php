<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function check_if_created_user_from_seeder_exists()
    {
        $this->assertDatabaseCount('users', 1);
    }
}
