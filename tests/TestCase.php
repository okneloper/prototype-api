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

    protected function asSales(): TestCase
    {
        return $this->withToken('2|mVIWH2VgQlWJpt7JfFHTUCkxwZVBFtBcLj75tNJT');
    }

    public function asCourier(): TestCase
    {
        return $this->withToken('3|gkw9V7bbQ6OgeFokLELSdhGBHG9eBVDLInnUwNoN');
    }
}
