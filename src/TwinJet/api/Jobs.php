<?php
namespace TwinJet;

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
     * @var string $_endpoint
     */
    protected $_endpoint;

    /**
     * HttpConnector object
     *
     * @var    HttpConnector $_connector
     */
    protected $_connector;

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
    }

    /**
     * newJob() function - Create a new Job using the provided data
     * @link https://twinjet.co/developer/#newjob
     *
     * @param array $data payload
     * @return array Result
     * @throws ApiException
     * @throws ConnectorException
     */
    public function newJob($data)
    {
        $endpoint =  $this->_endpoint->getJobsURL();
        return $this->_connector->processRequest('POST', $endpoint, $data);
    }

    /**
     * cancelJob() function - Cancel an existing Job using the provided data
     * @link https://twinjet.co/developer/#canceljob
     *
     * @param array $data payload
     * @return array Result
     * @throws ApiException
     * @throws ConnectorException
     */
    public function cancelJob($data)
    {
        $endpoint =  $this->_endpoint->getJobsURL();
        return $this->_connector->processRequest('DELETE', $endpoint, $data);
    }

    /**
     * cancelJob() function - Update an existing Job using the provided data
     * @link https://twinjet.co/developer/#canceljob
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
        return $this->_connector->processRequest('POST', $endpoint, $data);
    }
}