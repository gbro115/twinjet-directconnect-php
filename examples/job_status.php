<?php

namespace TwinJet;

use TwinJet\models\JobStatus;
use function json_encode;
use function print_r;
use function var_dump;

require __DIR__ . '/../vendor/autoload.php';

$apiToken = "API_TOKEN";
$jobStatus = new JobStatus();
$jobStatus->setApiToken($apiToken);
$jobStatus->setReference('REFERENCE');

$directConnect = new \TwinJet\DirectConnect($apiToken, '1');
$response = $directConnect->jobs()->getJobStatus($jobStatus);
var_dump($response);

