<?php


namespace TwinJet\models;


use DateTime;
use JsonException;
use JsonSerializable;
use function array_push;
use function is_null;
use function print_r;

class JobStatus implements JsonSerializable
{
    /**
     * @var string $_apiToken
     */
    protected $_apiToken;

    /**
     * @var string $_requestId
     */
    protected $_requestId;

    /**
     * @var string $_jobId
     */
    protected $_jobId;

    /**
     * @var string $_externalId
     */
    protected $_externalId;

    /**
     * @var string $_reference
     */
    protected $_reference;

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return $this->_apiToken;
    }

    /**
     * @param string $apiToken
     */
    public function setApiToken(string $apiToken): void
    {
        $this->_apiToken = $apiToken;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->_requestId;
    }

    /**
     * @param string $requestId
     */
    public function setRequestId(string $requestId): void
    {
        $this->_requestId = $requestId;
    }

    /**
     * @return string
     */
    public function getJobId(): string
    {
        return $this->_jobId;
    }

    /**
     * @param string $jobId
     */
    public function setJobId(string $jobId): void
    {
        $this->_jobId = $jobId;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->_externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId(string $externalId): void
    {
        $this->_externalId = $externalId;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->_reference;
    }

    /**
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->_reference = $reference;
    }

    /**
     * Serialize the JobStatus to TwinJet format
     *
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        if (is_null($this->_apiToken))
        {
            throw new JsonException(("API token not specified"));
        }

        if (
            is_null($this->_requestId) &&
            is_null($this->_jobId) &&
            is_null($this->_externalId) &&
            is_null($this->_reference)
        )
        {
            throw new JsonException(("In order to successfully obtain a job status, you must provide either a request ID, job ID, external ID or reference"));
        }

        $arr = array(
            'api_token'=>$this->_apiToken,
        );

        if(!is_null($this->_requestId))
        {
            $arr['request_id'] = $this->_requestId;
            return $arr;
        }
        elseif (!is_null($this->_jobId))
        {
            $arr['job_id'] = $this->_jobId;
            return $arr;
        }
        elseif (!is_null($this->_externalId))
        {
            $arr['external_id'] = $this->_externalId;
            return $arr;
        }
        elseif (!is_null($this->_reference))
        {
            $arr['reference'] = $this->_reference;
            return $arr;
        }

    }

}