<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Config;

class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        // Tworzymy tymczasowy plik test.env
        file_put_contents(__DIR__ . '/test.env', "TEST_KEY=test_value\n# komentarz\nANOTHER_KEY=another_value");
        Config::load(__DIR__ . '/test.env');
    }

    protected function tearDown(): void
    {
        if (file_exists(__DIR__ . '/test.env')) {
            unlink(__DIR__ . '/test.env');
        }
    }

    public function testGetReturnsLoadedValue(): void
    {
        $this->assertEquals('test_value', Config::get('TEST_KEY'));
        $this->assertEquals('another_value', Config::get('ANOTHER_KEY'));
    }

    public function testGetReturnsDefaultValueWhenKeyNotFound(): void
    {
        $this->assertEquals('default_val', Config::get('NON_EXISTENT_KEY_123', 'default_val'));
    }
}
