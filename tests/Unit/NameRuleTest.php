<?php

namespace Tests\Unit;

use App\Rules\Name;
use PHPUnit\Framework\TestCase;

class NameRuleTest extends TestCase
{
    /**
     * @dataProvider validNamesProvider
     */
    public function testValidNames($name): void
    {
        $rule = new Name();

        $this->assertTrue($rule->passes('name', $name));
    }

    /**
     * @dataProvider invalidNamesProvider
     */
    public function testInvalidNames($name): void
    {
        $rule = new Name();

        $this->assertFalse($rule->passes('name', $name));
    }

    public function validNamesProvider(): array
    {
        return [
            ['Jānis Kalniņš'],
            ['Jānis jr. Vilciņš-Kalniņš'],
            ['Вадим петров'],
        ];
    }

    public function invalidNamesProvider(): array
    {
        return [
            ['Jānis #Kalniņš'],
            [' '],
            ['test@exmaple.com'],
        ];
    }
}
