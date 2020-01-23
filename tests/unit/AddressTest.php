<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use TwinJet\models\Address;
use JsonException;
use InvalidArgumentException;

class AddressTest extends TestCase
{
    /**
     * Create an address and verify that the serialization matches TwinJet's requirements
     * @test
     */
    public function testAddressToJson(): void
    {
        $address = new Address();
        $address->setAddressName("P. Sherman");
        $address->setStreetAddress("32 Wallaby Way");
        $address->setFloor("1");
        $address->setCity("Sydney");
        $address->setState("CA");
        $address->setZipCode("123456");
        $address->setContact("P. Sherman");
        $address->setPhoneNumber("5141234567");
        $address->setSpecialInstructions("Bring fish food please");

        $expected = <<<JSON
{
    "address_name": "P. Sherman",
    "street_address": "32 Wallaby Way",
    "floor": "1",
    "city": "Sydney",
    "state": "CA",
    "zip_code": "123456",
    "contact": "P. Sherman",
    "special_instructions": "Bring fish food please"
}
JSON;

        $expectedJson = json_decode($expected);
        $this->assertEquals($expectedJson, json_decode(json_encode($address, JSON_FORCE_OBJECT)));
    }

    /**
     * Attempt to create an Address with a zip code longer than 6 digits.
     * An InvalidArgumentException should be thrown.
     *
     * @test
     */
    public function testAddressWithLongZipCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $address = new Address();
        $address->setZipCode("1234567891011");

    }

    /**
     * @test
     */
    public function testAddressSerializationWithoutStreetAddress(): void
    {
        $this->expectException(JsonException::class);
        $address = new Address();
        $address->setCity("Montreal");
        $address->setState("CA");
        $address->setZipCode("H224C9");
        json_encode($address);
    }

    /**
     * @test
     */
    public function testAddressSerializationWithoutCity(): void
    {
        $this->expectException(JsonException::class);
        $address = new Address();
        $address->setStreetAddress("Street address");
        $address->setState("CA");
        $address->setZipCode("H224C9");
        json_encode($address);
    }

    /**
     * @test
     */
    public function testAddressSerializationWithoutState(): void
    {
        $this->expectException(JsonException::class);
        $address = new Address();
        $address->setStreetAddress("Street address");
        $address->setCity("Montreal");
        $address->setZipCode("H224C9");
        json_encode($address);
    }

    /**
     * @test
     */
    public function testAddressSerializationWithoutZipCode(): void
    {
        $this->expectException(JsonException::class);
        $address = new Address();
        $address->setStreetAddress("Street address");
        $address->setCity("Montreal");
        $address->setState("CA");
        json_encode($address);
    }

    /**
     * @test
     */
    public function testZipCodeTrimming(): void
    {
        $address = new Address();
        $address->setAddressName("P. Sherman");
        $address->setStreetAddress("32 Wallaby Way");
        $address->setFloor("1");
        $address->setCity("Sydney");
        $address->setState("CA");
        $address->setZipCode("123   456");
        $address->setContact("P. Sherman");
        $address->setPhoneNumber("5141234567");
        $address->setSpecialInstructions("Bring fish food please");
        $this->assertEquals("123456", $address->getZipCode());
    }

    /**
     * @test
     */
    public function testStateTrimming(): void
    {
        $address = new Address();
        $address->setAddressName("P. Sherman");
        $address->setStreetAddress("32 Wallaby Way");
        $address->setFloor("1");
        $address->setCity("Sydney");
        $address->setState("C        A");
        $address->setZipCode("123   456");
        $address->setContact("P. Sherman");
        $address->setPhoneNumber("5141234567");
        $address->setSpecialInstructions("Bring fish food please");
        $this->assertEquals("CA", $address->getState());
    }

    /**
     * @test
     */
    public function testSetLongState(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $address = new Address();
        $address->setStreetAddress("Street address");
        $address->setState("NSW");
        $address->setZipCode("H224C9");
        json_encode($address);
    }
}
