TwinJet Direct Connect PHP API
==================

Composer-ready PHP wrapper for [TwinJet DirectConnect](https://twinjet.co/developer/).

Implemented calls:
1. Create Job
2. Job Status

Not yet implemented:
1. Update Job
2. Cancel Job

## Installation

The recommended way to install the library is using [Composer](https://getcomposer.org).

1) Add this json to your composer.json file:
```json
{
    "require": {
        "gbro115/twinjet-directconnect-php: "^1.1"
    }
}
```

2) Next, run this from the command line:
```
composer install
```
3) Finally, add this line to your php file that will be using the SDK:
```
require 'vendor/autoload.php';
```

## Limitations 

Not all actions have been implemented. 
 
## Handling Exceptions

If the API returns an error or an unexpected response, the PHP API will throw a \TwinJet\Exception.

## Example usage

```php
<?php
namespace TwinJet;

$apiToken = "YOUR_API_TOKEN";
$apiVersion = 'v1';

$directConnect = new \TwinJet\DirectConnect($apiToken, $apiVersion);

$jobStatusPayload = array(
    'api_token'=>$apiToken,
    'request_id'=>'1234'
);

$newJobPayload = array(
    'live'=>true,
    'api_token'=>$apiToken,
    'order_contact_name'=>'Joe Bloggs',
    'order_contact_phone'=>'+13333333333',
    'pick_address' => array(
        'address_name'=>'Address line 1',
        'street_address'=>'13 Wallaby Way',
        'city'=>'Montreal',
        'state'=>'QC',
        'zip_code'=>'XXXXXX',
        'contact'=>'Contact Name',
        'floor'=>'Ground floor',
        'phone_number'=>'+13333333333',
    ),
    'deliver_address' => array(
        'address_name'=>'Sherlock Holmes',
        'street_address'=>'8 Baker Street',
        'floor'=>'First floor',
        'city'=>'Montreal',
        'state'=>'QC',
        'zip_code'=>'XXXXXX',
        'contact'=>'Sherlock Holmes',
        'phone_number'=>'+13333333333',
    ),
    'ready_time' => '2020-01-17T20:33:39-05:00',
    'deliver_from_time' => '2020-01-17T20:33:39-05:00',
    'deliver_to_time' => '2020-01-17T21:03:39-05:00',
    'order_total' => 62.29,
    'payment_method' => '2',
    'special_instructions' => "Special instructions",
    'webhook_url' => 'https://callback.url',
    'external_id' => 123456
);

//$result = $directConnect->jobs()->newJob($newJobPayload);
//print_r($result);

//$result = $directConnect->jobs()->getJobStatus($jobStatusPayload);
//print_r($result);

```

See examples.php for further examples.

## Credits
Based on the [Bambora API PHP Client](https://github.com/bambora-na/beanstream-php)
