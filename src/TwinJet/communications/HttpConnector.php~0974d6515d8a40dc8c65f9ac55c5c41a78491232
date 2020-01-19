<?php

namespace TwinJet;


use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\ConnectException;
use \GuzzleHttp\Exception\RequestException;

/**
 * HTTPConnector class to handle HTTP requests to the REST API
 *
 * @author George Brownlee
 */
class HttpConnector {

    /**
     * Constructor
     */
    function __construct() {
    }

    /**
     * processRequest() function - Public facing function to send a request to an endpoint.
     *
     * @param string $http_method HTTP method to use (defaults to GET if $data==null; defaults to PUT if $data!=null)
     * @param string $endpoint Incoming API Endpoint
     * @param array $data Data for POST requests, not needed for GETs
     * @return    array    Parsed API response from private request method
     * @throws ApiException
     * @throws ConnectorException
     * @access    public
     */
    public function processRequest($http_method, $endpoint, $data) {
        //call internal request function
        return $this->request($http_method, $endpoint, $data);
    }


    /**
     * request() function - Internal function to send a request to an endpoint.
     *
     * @param	string|null	$http_method HTTP method to use (defaults to GET if $data==null; defaults to POST if $data!=null)
     * @param	string $url	Incoming API Endpoint
     * @param	array|null	$data Data for POST requests, not needed for GETs
     * @access	private
     * @return	array Parsed API response
     *
     * @throws ApiException
     * @throws ConnectorException
     */
    private function request($http_method = 'GET', $url, $data = NULL)
    {
        $client = new Client();

        $response = null;
        $options = array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            )
        );

        if( !is_null($data))
        {
            $options['body'] = json_encode($data);
        }

        try {
            $response = $client->request($http_method, $url, $options);
        }
        catch (RequestException | ConnectException $e)
        {
            throw new ConnectorException('Unexpected Guzzle error ' . $e->getMessage(), 0);
        }

        if (false === $response) { //make sure we got something back
            throw new ConnectorException("No response was received", 0);
        }

        if (is_null($response)) {
            throw new ConnectorException('Unexpected response format', 0);
        }

        $res = json_decode($response->getBody(),true);

        // Check for HTTP error codes
        $statusCode = $response->getStatusCode();
        if( !($statusCode >= 200 && $statusCode < 300) )
        {
            throw new ApiException("", $statusCode);
        }

        return $res;
    }

}