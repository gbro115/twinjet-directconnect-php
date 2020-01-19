<?php
namespace TwinJet;

/**
 * Endpoints class to build, format and return API endpoint urls based on incoming platform and version
 *
 * @author George Brownlee
 */
class Endpoints {

    /**
     * Endpoints: Set BASE API Endpoint URL
     */
    CONST BASE_URL_TWINJET = 'https://www.twinjet.co';

    /**
     * Endpoint URL holders
     *
     * Holds each of the URLS for the API endpoints
     * Version is added in the constructor
     *
     */
    protected $jobsURL;
    protected $statusURL;

    /**
     * Endpoint: incoming API Version
     *
     * @var string $_version
     */
    protected $_version;

    /**
     * Constructor
     *
     * @param string $version API Version
     */
    function __construct($version)
    {

        //assign endpoints
        $baseUrl =  self::BASE_URL_TWINJET . '/api/' . '{0}';

        // Jobs
        $this->jobsURL = $baseUrl . '/jobs';

        // Status
        $this->statusURL = $baseUrl . '/status';

        // Address Verification
        $this->addressVerificationURL = $baseUrl . '/validate';

        //assign incoming version
        $this->_version = $version;

    }

    //methods to build out and return endpoints

    /**
     * getJobsURL() function
     *
     * @return string	Endpoint URL
     */
    public function getJobsURL()
    {
        return str_replace(array('{0}'), array($this->_version), $this->jobsURL);
    }

    /**
     * getStatusURL() function
     *
     * @return string	Endpoint URL
     */
    public function getStatusURL()
    {
        return str_replace(array('{0}'), array($this->_version), $this->statusURL);
    }

    /**
     * getAddressVerificationURL() function
     *
     * @return string	Endpoint URL
     */
    public function getAddressVerificationURL()
    {
        return str_replace(array('{0}'), array($this->_version), $this->addressVerificationURL);
    }

}