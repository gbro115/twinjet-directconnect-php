<?php

namespace TwinJet;

require_once 'Exception.php';
require_once 'Configuration.php';
require_once 'communications/Endpoints.php';
require_once 'communications/HttpConnector.php';
require_once 'api/Jobs.php';

/**
 * DirectConnect class - Main class to facilitate communications with TwinJet DirectConnect
 *
 * @author George Brownlee
 */
class DirectConnect {

    /**
     * Config object
     *
     * @var	Configuration	$_config
     */
    protected $_config;

    /**
     * API Objects
     *
     * Holds API objects with appropriate config
     *
     * @var	Jobs $_jobsAPI
     */
    protected $_jobsAPI;

    /**
     * Constructor
     *
     * @param string $apiToken API Token
     * @param string $version API Version (default 'v1')
     * @throws ConfigurationException
     */
    public function __construct($apiToken, $version='v1')
    {
        //set configs
        $this->_config = new Configuration();
        $this->_config->setApiToken($apiToken);;
        $this->_config->setApiVersion($version);
    }

    /**
     * getConfig() function
     *
     * @return Configuration the config set for the DirectConnect instance
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * jobs() function
     *
     * Public facing function to return the configured Jobs API
     *
     * @return Jobs this DirectConnect's Jobs API
     */
    public function jobs()
    {
        if (is_null($this->_jobsAPI)) {
            $this->_jobsAPI = new Jobs($this->_config);
        }
        return $this->_jobsAPI;
    }

}