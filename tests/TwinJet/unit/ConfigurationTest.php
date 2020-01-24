<?php


namespace tests\TwinJet\unit;


use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TwinJet\Configuration;

class ConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function testToken(): void
    {
        $token = "TOKEN123456";
        $apiVersion = "v1";
        $c = new Configuration();
        $c->setApiToken($token);
        $this->assertEquals($token, $c->getApiToken());
    }

    /**
     * @test
     */
    public function testApiVersion(): void
    {
        $apiVersion = "v1";
        $c = new Configuration();
        $c->setApiVersion($apiVersion);
        $this->assertEquals($apiVersion, $c->getApiVersion());
    }

    /**
     * @test
     */
    public function testInvalidApiVersion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $apiVersion = "v9";
        $c = new Configuration();
        $c->setApiVersion($apiVersion);
        $this->assertEquals($apiVersion, $c->getApiVersion());
    }


}