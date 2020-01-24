<?php

namespace tests\TwinJet\unit;

use PHPUnit\Framework\TestCase;
use TwinJet\communications\Endpoints;

class EndpointsTest extends TestCase
{

    /**
     * @test
     */
    public function testGetStatusURL()
    {
        $ep = new Endpoints('v1');
        $this->assertEquals('https://www.twinjet.co/api/v1/status', $ep->getStatusURL());
    }

    /**
     * @test
     */
    public function testGetAddressVerificationURL()
    {
        $ep = new Endpoints('v1');
        $this->assertEquals('https://www.twinjet.co/api/v1/validate', $ep->getAddressVerificationURL());
    }

    /**
     * @test
     */
    public function testGetJobsURL()
    {
        $ep = new Endpoints('v1');
        $this->assertEquals('https://www.twinjet.co/api/v1/jobs', $ep->getJobsURL());
    }
}
