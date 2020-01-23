<?php


namespace integration;

use DateTimeZone;
use PHPUnit\Framework\TestCase;
use TwinJet\models\Address;
use TwinJet\models\constants\PaymentMethod;
use TwinJet\models\Job;
use TwinJet\models\JobItem;
use function json_decode;
use function json_encode;
use const JSON_FORCE_OBJECT;
use const JSON_PRETTY_PRINT;

class JobTest extends TestCase
{
    /**
     * Create an address and verify that the serialization matches TwinJet's requirements
     * @test
     */
    public function testAddressToJson(): void
    {
        $dateFormat = 'Y-m-d H:i:s';

        $job = new Job();
        $job->setIsLive(true);
        $job->setApiToken("APITOKEN1234567");
        $job->setOrderContactName("Contact name");
        $job->setOrderContactPhone("5141234567");

        $readyTime = date_create_from_format($dateFormat, '2019-02-15 15:16:17', new DateTimeZone('America/Toronto'));
        $job->setReadyTime($readyTime);

        $deliverFromTime = date_create_from_format($dateFormat, '2019-02-15 18:16:17', new DateTimeZone('America/Toronto'));
        $job->setDeliverFromDateTime($deliverFromTime);

        $deliverToTime = date_create_from_format($dateFormat, '2019-02-15 18:36:17', new DateTimeZone('America/Toronto'));
        $job->setDeliverToDateTime($deliverToTime);

        $job->setWebhookUrl("http://foo.com/callback");
        $job->setReference("ReferenceCode");
        $job->setServiceId(2);
        $job->setPaymentMethod(PaymentMethod::CUSTOMER_CASH);
        $job->setOrderTotal(100);
        $job->setDeliveryFee(10);
        $job->setTip(1.5);

        $item1 = new JobItem();
        $item1->setSku("SKU1");
        $item1->setDescription("SKU one");
        $item1->setQuantity(1);
        $job->addJobItem($item1);

        $item2 = new JobItem();
        $item2->setSku("SKU2");
        $item2->setDescription("SKU two");
        $item2->setQuantity(2);
        $job->addJobItem($item2);

        $job->setSpecialInstructions("Special instructions");
        $job->setRequirePhotoOnDelivery(true);
        $job->setExternalId("External ID");

        $pickAddress = new Address();
        $pickAddress->setAddressName("P. Sherman");
        $pickAddress->setStreetAddress("32 Wallaby Way");
        $pickAddress->setFloor("1");
        $pickAddress->setCity("Sydney");
        $pickAddress->setState("CA");
        $pickAddress->setZipCode("123456");
        $pickAddress->setContact("P. Sherman");
        $pickAddress->setPhoneNumber("5141234567");
        $pickAddress->setSpecialInstructions("Large delivery");

        $deliveryAddress = new Address();
        $deliveryAddress->setAddressName("Mr J. Recipient");
        $deliveryAddress->setStreetAddress("101 Foo Street");
        $deliveryAddress->setFloor("1");
        $deliveryAddress->setCity("Melbourne");
        $deliveryAddress->setState("CA");
        $deliveryAddress->setZipCode("876543");
        $deliveryAddress->setContact("Mr Recipient");
        $deliveryAddress->setPhoneNumber("4381234567");
        $deliveryAddress->setSpecialInstructions("Ring doorbell");

        $job->setPickupAddress($pickAddress);
        $job->setDeliveryAddress($deliveryAddress);
        $job->setSpecialInstructions("Job-level special instructions");

        $expected = <<<JSON
{
    "live": true,
    "api_token": "APITOKEN1234567",
    "order_contact_name": "Contact name",
    "order_contact_phone": "5141234567",
    "pick_address": {
        "address_name": "P. Sherman",
        "street_address": "32 Wallaby Way",
        "floor": "1",
        "city": "Sydney",
        "state": "CA",
        "zip_code": "123456",
        "contact": "P. Sherman",
        "special_instructions": "Large delivery"
    },
    "deliver_address": {
        "address_name": "Mr J. Recipient",
        "street_address": "101 Foo Street",
        "floor": "1",
        "city": "Melbourne",
        "state": "CA",
        "zip_code": "876543",
        "contact": "Mr Recipient",
        "special_instructions": "Ring doorbell"
    },
    "ready_time": "2019-02-15T15:16:17-0500",
    "deliver_from_time": "2019-02-15T18:16:17-0500",
    "deliver_to_time": "2019-02-15T18:36:17-0500",
    "service_id": 2,
    "order_total": 100,
    "tip": 1.5,
    "webhook_url": "http:\/\/foo.com\/callback",
    "job_items": [
        {
            "quantity": 1,
            "description": "SKU one",
            "sku": "SKU1"
        },
        {
            "quantity": 2,
            "description": "SKU two",
            "sku": "SKU2"
        }
    ]
}
JSON;

        $expectedJson = json_decode($expected);

        $this->assertEquals($expectedJson, json_decode(json_encode($job)));
    }
}