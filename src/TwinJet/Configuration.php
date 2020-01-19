<?php
namespace TwinJet;

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
     * Configuration: API Platform
     *
     * @var string $_platform
     */
    protected $_platform = 'api'; //default

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
    public function setApiToken($apiToken = '') {
        $this->_apiToken = $apiToken;
    }

    /**
     * getApiToken() function
     *
     * @return string API token
     */
    public function getApiToken() {
        return $this->_apiToken;
    }

    /**
     * setApiVersion() function
     *
     * @param string $version
     * @return void
     * @throws ConfigurationException
     */
    public function setApiVersion($version = '') {
        //make sure it's not blank
        //if blank, don't set it and use default declared above
        if($version != 'v1')
        {
            throw new ConfigurationException('Only version 1 is supported in this version.');
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
    public function getApiVersion() {
        return $this->_version;
    }
}