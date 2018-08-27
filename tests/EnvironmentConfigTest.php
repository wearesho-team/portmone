<?php

namespace Wearesho\Bobra\Portmone\Tests;

use Wearesho\Bobra\Portmone\EnvironmentConfig;

use PHPUnit\Framework\TestCase;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Portmone\Tests
 * @coversDefaultClass EnvironmentConfig
 * @internal
 */
class EnvironmentConfigTest extends TestCase
{
    protected const KEY = 'testKey';
    protected const URL = 'testUrl';
    protected const PAYEE = 'testPayee';
    protected const LANGUAGE = 'testLanguage';
    protected const SECRET = 'testSecret';

    /** @var EnvironmentConfig */
    protected $fakeEnvironmentConfig;

    protected function setUp(): void
    {
        $this->fakeEnvironmentConfig = new EnvironmentConfig();
    }

    public function testGetKey(): void
    {
        putenv('PORTMONE_KEY=' . static::KEY);
        
        $this->assertEquals(
            static::KEY,
            $this->fakeEnvironmentConfig->getKey()
        );
    }

    /**
     * @expectedException \Horat1us\Environment\MissingEnvironmentException
     * @expectedExceptionMessage Missing environment key PORTMONE_KEY
     */
    public function testGetEmptyKey(): void
    {
        putenv('PORTMONE_KEY');

        $this->fakeEnvironmentConfig->getKey();
    }

    public function testGetUrl(): void
    {
        putenv('PORTMONE_URL=' . static::URL);

        $this->assertEquals(
            static::URL,
            $this->fakeEnvironmentConfig->getUrl()
        );
    }

    /**
     * @expectedException \Horat1us\Environment\MissingEnvironmentException
     * @expectedExceptionMessage Missing environment key PORTMONE_URL
     */
    public function testGetEmptyUrl(): void
    {
        putenv('PORTMONE_URL');

        $this->fakeEnvironmentConfig->getUrl();
    }

    public function testGetPayee(): void
    {
        putenv('PORTMONE_PAYEE=' . static::PAYEE);

        $this->assertEquals(
            static::PAYEE,
            $this->fakeEnvironmentConfig->getPayee()
        );
    }

    /**
     * @expectedException \Horat1us\Environment\MissingEnvironmentException
     * @expectedExceptionMessage Missing environment key PORTMONE_PAYEE
     */
    public function testGetEmptyPayee(): void
    {
        putenv('PORTMONE_PAYEE');

        $this->fakeEnvironmentConfig->getPayee();
    }

    public function testGetLanguage(): void
    {
        putenv('PORTMONE_LANGUAGE=' . static::LANGUAGE);

        $this->assertEquals(
            static::LANGUAGE,
            $this->fakeEnvironmentConfig->getLanguage()
        );
    }

    /**
     * @expectedException \Horat1us\Environment\MissingEnvironmentException
     * @expectedExceptionMessage Missing environment key PORTMONE_LANGUAGE
     */
    public function testGetEmptyLanguage(): void
    {
        putenv('PORTMONE_LANGUAGE');

        $this->fakeEnvironmentConfig->getLanguage();
    }

    public function testGetSecret(): void
    {
        putenv('PORTMONE_SECRET=' . static::SECRET);

        $this->assertEquals(
            static::SECRET,
            $this->fakeEnvironmentConfig->getSecret()
        );
    }

    /**
     * @expectedException \Horat1us\Environment\MissingEnvironmentException
     * @expectedExceptionMessage Missing environment key PORTMONE_SECRET
     */
    public function testGetEmptySecret(): void
    {
        putenv('PORTMONE_SECRET');

        $this->fakeEnvironmentConfig->getSecret();
    }
}
