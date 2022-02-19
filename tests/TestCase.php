<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function asCustomer(): TestCase
    {
        return $this->withToken('1|RyBbpYpNUqCUFz3QaDgMaY5SaKj5bbnz1s5HI43B');
    }
}
