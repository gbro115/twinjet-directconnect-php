<?php
namespace TwinJet;

use InvalidArgumentException;

/**
 * Configuration class to handle version and API token
 *
 * @author George Brownlee
 */
class Configuration {

    /**
     * Configuration: API Version
     *
     * @var string $_version
     */
    protected $_version = 'v1'; //default

    /**
     * Configuration: API Token
     *
     * @var string $_apiToken
     */
    protected $_apiToken;

    /**
     * setApiToken() function
     *
     * @param string $apiToken
     */
    public function setApiToken($apiToken = '')
    {
        $this->_apiToken = $apiToken;
    }

    /**
     * getApiToken() function
     *
     * @return string API token
     */
    public function getApiToken()
    {
        return $this->_apiToken;
    }

    /**
     * setApiVersion() function
     *
     * @param int $version
     * @return void
     */
    public function setApiVersion($version = 1)
    {
        if($version != 1)
        {
            throw new InvalidArgumentException('Only version 1 is supported in this release.');
        }
        if (strlen($version) > 0)
        {
            $this->_version=$version;
        }
    }

    /**
     * getApiVersion() function
     *
     * @return string version
     */
    public function getApiVersion()
    {
        return $this->_version;
    }
}