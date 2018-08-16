<?php

namespace Wearesho\Bobra\Portmone\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Portmone;

/**
 * Class ConfigTest
 * @package Wearesho\Bobra\Portmone\Tests
 */
class ConfigTest extends TestCase
{
    protected const KEY = 'testKey';
    protected const SECRET = 'testSecret';
    protected const PAYEE = 'testPayee';
    protected const REQUEST_URL = 'testUrl';

    /** @var Portmone\Config */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Portmone\Config(
            static::KEY,
            static::SECRET,
            static::PAYEE,
            static::REQUEST_URL
        );
    }

    public function testKey(): void
    {
        $this->assertEquals(
            static::KEY,
            $this->config->getKey()
        );
    }

    public function testSecret(): void
    {
        $this->assertEquals(
            static::SECRET,
            $this->config->getSecret()
        );
    }

    public function testPayee(): void
    {
        $this->assertEquals(
            static::PAYEE,
            $this->config->getPayee()
        );
    }

    public function testLanguage(): void
    {
        $this->assertEquals(
            Portmone\Language::RU,
            $this->config->getLanguage()
        );
    }

    public function testGetRequestUrl(): void
    {
        $this->assertEquals(static::REQUEST_URL, $this->config->getRequestUrl());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported language invalidLanguage
     */
    public function testInvalidLanguage(): void
    {
        new Portmone\Config(
            static::KEY,
            static::SECRET,
            static::PAYEE,
            static::REQUEST_URL,
            'invalidLanguage'
        );
    }
}
