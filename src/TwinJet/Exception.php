<?php
namespace TwinJet;

/**
 * Exception class
 *
 * TwinJet specific exception types
 *
 * Zero error code corresponds to PHP API specific errors
 * Summary of error codes
 * @link https://twinjet.co/developer/#statuscodes
 *
 * @author George Brownlee
 *
 */
class Exception extends \Exception {

    /**
     * Exception: Message class variable
     *
     * @var string $_message holds the error message string
     */
    protected $_message;

    /**
     * Exception: Code instance variable
     *
     * @var int $_code holds the error message code (0=PHP, Positive=TwinJet API, Negative=cURL)
     */	protected $_code;

    /**
     * Constructor
     *
     * @param string $message Exception message
     * @param int $code Exception code (0=PHP[default], Positive=TwinJet API, Negative=cURL)
     */
    public function __construct($message, $code = 0)
    {
        $this->_message = $message;
        $this->_code = $code;
        parent::__construct($this->_message, $this->_code);
    }
}

/**
 * ConfigurationException class
 */
class ConfigurationException extends Exception {}

/**
 * ConnectorException class
 */
class ConnectorException extends Exception {}

/**
 * ApiException class
 */
class ApiException extends Exception {}