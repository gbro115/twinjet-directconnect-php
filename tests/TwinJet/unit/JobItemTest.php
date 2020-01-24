<?php

namespace tests\TwinJet\unit;

use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\TestCase;
use TwinJet\models\Address;
use TwinJet\models\JobItem;
use function json_decode;
use function json_encode;
use function print_r;
use const JSON_PRETTY_PRINT;

class JobItemTest extends TestCase
{

    /**
     * Create a JobItem and verify that JSON serialization results in an object that
     * meets TwinJet's requirements.
     *
     * @test
     */
    public function testJobItemToJson()
    {
        $jobItem = new JobItem();
        $jobItem->setSku("SKU12345");
        $jobItem->setQuantity(3);
        $jobItem->setDescription("French hens");

        $expected = <<<JSON
{
    "quantity": 3,
    "description": "French hens",
    "sku": "SKU12345"
}
JSON;

        $expectedJson = json_decode($expected);
        $this->assertEquals($expectedJson, json_decode(json_encode($jobItem, JSON_FORCE_OBJECT)));
    }

    /**
     * Attempt to create Job item without a quantity.
     * A JsonException should be thrown when attempting to serialize.
     *
     * @test
     */
    public function testAddressWithLongZipCode(): void
    {
        $this->expectException(JsonException::class);
        $address = new JobItem();
        $address->setSku("SKU12345");
        $address->setDescription("Exception SKU");
        json_encode($address);
    }

}
