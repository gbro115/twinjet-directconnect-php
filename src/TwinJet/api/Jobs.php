<?php
namespace TwinJet\api;

use TwinJet\ApiException;
use TwinJet\communications\Endpoints;
use TwinJet\communications\HttpConnector;
use TwinJet\Configuration;
use TwinJet\ConnectorException;
use function json_encode;
use const JSON_PRETTY_PRINT;

/**
 * Jobs class to submit, update and cancel jobs.
 * Allows for querying of the status/history for an existing job.
 *
 * @author George Brownlee
 */
class Jobs {


    /**
     * Jobs Endpoint object
     *
     * @var Endpoints $_endpoint
     */
    protected $_endpoint;

    /**
     * HttpConnector object
     *
     * @var    HttpConnector $_connector
     */
    protected $_connector;

    /**
     * API key, used in Job Status and Cancel Job requests
     * @var string $_apiToken
     */
    protected $_apiToken;

    /**
     * Constructor
     *
     * Inits the appropriate endpoint and httpconnector objects
     * Sets all of the Payments class properties
     *
     * @param Configuration $config
     */
    function __construct(Configuration $config)
    {
        $this->_endpoint = new Endpoints($config->getApiVersion());
        $this->_connector = new HttpConnector();
        $this->_apiToken = $config->getApiToken();
    }

    /**
     * newJob() function - Create a new Job using the provided data
     * @link https://twinjet.co/developer/#newjob
     *
     * @param $job
     * @return array Result
     * @throws ApiException
     * @throws ConnectorException
     */
    public function newJob($job)
    {
        $endpoint =  $this->_endpoint->getJobsURL();
        echo(json_encode($job, JSON_PRETTY_PRINT));
        return $this->_connector->processRequest('POST', $endpoint, $job);
    }

    /**
     * cancelJob() function - Cancel an existing Job using the provided data
     * @link https://twinjet.co/developer/#canceljob
     *
     * @return array Result
     * @throws ApiException
     * @throws ConnectorException
     */
    public function cancelJob($job)
    {

        $endpoint =  $this->_endpoint->getJobsURL();
        return $this->_connector->processRequest('DELETE', $endpoint, $data);
    }

    /**
     * updateJob() function - Update an existing Job using the provided data
     * @link https://twinjet.co/developer/
     *
     * @param array $data payload
     * @return array Result
     * @throws ApiException
     * @throws ConnectorException
     */
    public function updateJob($data)
    {
        $endpoint =  $this->_endpoint->getJobsURL();
        return $this->_connector->processRequest('PATCH', $endpoint, $data);
    }

    /**
     * getJobStatus() function - Get the status of an existing Job
     * @link https://twinjet.co/developer/#jobstatus
     *
     * @param array $data payload
     * @return array Result
     * @throws ApiException
     * @throws ConnectorException
     */
    public function getJobStatus($data)
    {
        $endpoint =  $this->_endpoint->getStatusURL();
        echo json_encode($data, JSON_PRETTY_PRINT);
        #return $this->_connector->processRequest('POST', $endpoint, $data);
    }

    /**
     * Set Jobs URL during unit tests.
     *
     * @param $url
     */
    private function setJobsUrl($url)
    {
        $this->_endpoint->setJobsUrl($url);
    }
}