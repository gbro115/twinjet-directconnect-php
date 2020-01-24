<?php
namespace TwinJet;
require __DIR__ . '/../vendor/autoload.php';

use DateTimeZone;
use TwinJet\models\Address;
use TwinJet\models\constants\PaymentMethod;
use TwinJet\models\Job;
use TwinJet\models\JobItem;
use function date_create_from_format;
use function json_encode;
use function print_r;

$apiToken = "YOUR_API_TOKEN";
$apiVersion = 1;

$dateFormat = 'Y-m-d H:i:s';

$job = new Job();
$job->setIsLive(true);
$job->setApiToken($apiToken);
$job->setOrderContactName("Contact name");
$job->setOrderContactPhone("5141234567");

$readyTime = date_create_from_format($dateFormat, '2020-01-25 15:16:17', new DateTimeZone('America/Toronto'));
$job->setReadyTime($readyTime);

$deliverFromTime = date_create_from_format($dateFormat, '2020-01-25 18:16:17', new DateTimeZone('America/Toronto'));
$job->setDeliverFromDateTime($deliverFromTime);

$deliverToTime = date_create_from_format($dateFormat, '2019-02-25 18:36:17', new DateTimeZone('America/Toronto'));
$job->setDeliverToDateTime($deliverToTime);

$job->setWebhookUrl("http://foo.com/callback");
$job->setReference("ReferenceCode");
//$job->setServiceId(2);
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

$directConnect = new \TwinJet\DirectConnect($apiToken, $apiVersion);
$response = $directConnect->jobs()->newJob($job);

echo "Response was: " . json_encode($response);

//$result = $directConnect->jobs()->newJob($newJobPayload);
//print_r($result);

//$result = $directConnect->jobs()->getJobStatus($jobStatusPayload);
//print_r($result);
