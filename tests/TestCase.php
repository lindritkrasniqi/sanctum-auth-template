<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $seed = true;

    // credentials for existing User
    protected $credentials = [
        "email" => "lindritkrasniqi@example.com",
        "password" => "password"
    ];
}
