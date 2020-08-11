<?php

namespace TwinJet\models;

use ClusterPOS\models\OnlineOrder\constants\OptionType;
use DateTime;
use InvalidArgumentException;
use JsonException;
use JsonSerializable;
use ReflectionException;
use TwinJet\models\constants\PaymentMethod;
use function in_array;
use function is_null;

/**
 * Class Job
 * @package TwinJet\models
 *
 * Please note In order to successfully submit an order, you must provide either:
 * pickupAddress
 * deliveryAddress
 * Both pickupAddress and deliveryAddress
 *
 * When you only provide a pickupAddress, TwinJet will use the client location as the
 * delivery address. Likewise, when you provide only the deliveryAddress, TwinJet will use
 * your client location as the pick address.
 *
 */
class Job implements JsonSerializable
{
    /**
     * @var boolean
     */
    protected $_isLive;

    /**
     * @var string
     */
    protected $_apiToken;

    /**
     * @var string
     */
    protected $_orderContactName;

    /**
     * @var string
     */
    protected $_orderContactPhone;

    /**
     * @var Address
     */
    protected $_pickupAddress;

    /**
     * @var Address
     */
    protected $_deliveryAddress;

    /**
     * @var DateTime
     */
    protected $_readyTime;

    /**
     * @var DateTime
     */
    protected $_deliverFromDateTime;

    /**
     * @var DateTime
     */
    protected $_deliverToDateTime;

    /**
     * @var string
     */
    protected $_webhookUrl;

    /**
     * @var string
     */
    protected $_reference;

    /**
     * @var string
     */
    protected $_serviceId;

    /**
     * @var int
     */
    protected $_paymentMethod;

    /**
     * @var float
     */
    protected $_orderTotal;

    /**
     * @var float
     */
    protected $_deliveryFee;

    /**
     * @var float
     */
    protected $_tip;

    /**
     * @var array
     */
    protected $_jobItems;

    /**
     * @var string
     */
    protected $_specialInstructions;

    /**
     * @var boolean
     */
    protected $_requirePhotoOnDelivery;

    /**
     * @var string
     */
    protected $_externalId;

    /**
     * Job constructor.
     */
    function __construct()
    {
        $this->_jobItems = array();
        $this->_tip = 0;
    }

    /**
     * Add a JobItem to the array of JobItems for this Job.
     * Returns the array of JobItems.
     *
     * @param JobItem $jobItem
     * @return array
     */
    public function addJobItem(JobItem $jobItem): array
    {
        $this->_jobItems[] = $jobItem;
        return $this->_jobItems;
    }

    /**
     * Determines if this job should be processed by TwinJet.
     * In the future, you will be able to inspect jobs marked as false in an API request inspector.
     * For now, make sure this is set to true.
     * Required.
     *
     * @return bool
     */
    public function isLive(): bool
    {
        return $this->_isLive;
    }


    /**
     * Determines if this job should be processed by TwinJet.
     * In the future, you will be able to inspect jobs marked as false in an API request inspector.
     * For now, make sure this is set to true.
     * Required.
     *
     * @param bool $isLive
     */
    public function setIsLive(bool $isLive): void
    {
        $this->_isLive = $isLive;
    }

    /**
     * This is your api token issued by your company.
     * This will identify you and provide authentication.
     * Required.
     *
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
     * Name of a person the courier company can contact if there is a problem with your order.
     * This should not be the recipient of the delivery, but rather somebody the courier can contact
     * if something goes wrong with the fulfillment of the job.
     * Required.
     *
     * @return string
     */
    public function getOrderContactName(): string
    {
        return $this->_orderContactName;
    }

    /**
     * Name of a person the courier company can contact if there is a problem with your order.
     * This should not be the recipient of the delivery, but rather somebody the courier can contact
     * if something goes wrong with the fulfillment of the job.
     * Required.
     *
     * @param string $orderContactName
     */
    public function setOrderContactName(string $orderContactName): void
    {
        $this->_orderContactName = $orderContactName;
    }

    /**
     * Phone number of a person the courier company can contact if there is a problem with your order.
     * This should not be the recipient of the delivery, but rather somebody the courier can contact
     * if something goes wrong with the fulfillment of the job.
     * Required.
     *
     * @return string
     */
    public function getOrderContactPhone()
    {
        return $this->_orderContactPhone;
    }

    /**
     * Phone number of a person the courier company can contact if there is a problem with your order.
     * This should not be the recipient of the delivery, but rather somebody the courier can contact
     * if something goes wrong with the fulfillment of the job.
     * Required.
     *
     * @param string $orderContactPhone
     */
    public function setOrderContactPhone($orderContactPhone): void
    {
        $this->_orderContactPhone = $orderContactPhone;
    }

    /**
     * The address where the courier should make the pick up.
     * Not required (see note in class doc)
     *
     * @return Address
     */
    public function getPickupAddress(): Address
    {
        return $this->_pickupAddress;
    }

    /**
     * The address where the courier should make the pick up.
     * Not required (see note in class doc)
     *
     * @param Address $pickupAddress
     */
    public function setPickupAddress(Address $pickupAddress): void
    {
        $this->_pickupAddress = $pickupAddress;
    }

    /**
     * The address where the courier should make the delivery.
     * Not required (see note in class doc)
     *
     * @return Address
     */
    public function getDeliveryAddress(): Address
    {
        return $this->_deliveryAddress;
    }

    /**
     * The address where the courier should make the delivery.
     * Not required (see note in class doc)
     *
     * @param Address $deliveryAddress
     */
    public function setDeliveryAddress(Address $deliveryAddress): void
    {
        $this->_deliveryAddress = $deliveryAddress;
    }

    /**
     * The date and time that a job is ready for pick up.
     *
     * @return DateTime
     */
    public function getReadyTime(): DateTime
    {
        return $this->_readyTime;
    }

    /**
     * The date and time that a job is ready for pick up.
     *
     * @param DateTime $readyTime
     */
    public function setReadyTime(DateTime $readyTime): void
    {
        $this->_readyTime = $readyTime;
    }

    /**
     * The date and time representing the beginning of the delivery window
     *
     * @return DateTime
     */
    public function getDeliverFromDateTime(): DateTime
    {
        return $this->_deliverFromDateTime;
    }

    /**
     * The date and time representing the beginning of the delivery window
     *
     * @param DateTime $deliverFromDateTime
     */
    public function setDeliverFromDateTime(DateTime $deliverFromDateTime): void
    {
        $this->_deliverFromDateTime = $deliverFromDateTime;
    }

    /**
     * The date and time representing the end of the delivery window
     *
     * @return DateTime
     */
    public function getDeliverToDateTime(): DateTime
    {
        return $this->_deliverToDateTime;
    }

    /**
     * The date and time representing the end of the delivery window
     *
     * @param DateTime $deliverToDateTime
     */
    public function setDeliverToDateTime(DateTime $deliverToDateTime): void
    {
        $this->_deliverToDateTime = $deliverToDateTime;
    }

    /**
     * URL to receive webhook events.
     *
     * @return string
     */
    public function getWebhookUrl(): string
    {
        return $this->_webhookUrl;
    }

    /**
     * URL to receive webhook events.
     *
     * @param string $webhookUrl
     */
    public function setWebhookUrl(string $webhookUrl): void
    {
        $this->_webhookUrl = $webhookUrl;
    }

    /**
     * A job reference for billing purposes. Not required (see note in class doc).
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->_reference;
    }

    /**
     * A job reference for billing purposes. Not required (see note in class doc)
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->_reference = $reference;
    }

    /**
     * The ID for the service level. This ID would be provided by the courier company
     * and only used for changing the service from the default
     * (eg: upgrading from the default "Same-Day" service to "1-Hour").
     *
     * @return int
     */
    public function getServiceId(): int
    {
        return $this->_serviceId;
    }

    /**
     * The ID for the service level. This ID would be provided by the courier company
     * and only used for changing the service from the default
     * (eg: upgrading from the default "Same-Day" service to "1-Hour").
     *
     * @param int $serviceId
     */
    public function setServiceId(int $serviceId): void
    {
        $this->_serviceId = $serviceId;
    }

    /**
     * 	Payment method for the delivery.
     *
     * @return int
     */
    public function getPaymentMethod(): int
    {
        return $this->_paymentMethod;
    }

    /**
     *    Payment method for the delivery.
     *
     * @param int $paymentMethod
     * @throws ReflectionException
     */
    public function setPaymentMethod($paymentMethod): void
    {
        if (!in_array($paymentMethod, PaymentMethod::getConstants())) {
            throw new InvalidArgumentException("$paymentMethod is not a valid PaymentMethod.");
        }
        $this->_paymentMethod = $paymentMethod;
    }

    /**
     *  The order total
     *
     * @return float
     */
    public function getOrderTotal(): float
    {
        return $this->_orderTotal;
    }

    /**
     * @param float $orderTotal
     */
    public function setOrderTotal(float $orderTotal): void
    {
        $this->_orderTotal = $orderTotal;
    }

    /**
     * The order delivery fee.
     *
     * @return float
     */
    public function getDeliveryFee(): float
    {
        return $this->_deliveryFee;
    }

    /**
     * The order delivery fee.
     *
     * @param float $deliveryFee
     */
    public function setDeliveryFee(float $deliveryFee): void
    {
        $this->_deliveryFee = $deliveryFee;
    }

    /**
     * The order tip
     *
     * @return float
     */
    public function getTip(): float
    {
        return $this->_tip;
    }

    /**
     * The order tip
     *
     * @param float $tip
     */
    public function setTip(float $tip): void
    {
        $this->_tip = $tip;
    }

    /**
     * If you went to pass specific information on what the courier should pick up, you may pass
     * an array of @link JobItem objects detailed below.
     *
     * @return JobItem[]
     */
    public function getJobItems(): array
    {
        return $this->_jobItems;
    }

    /**
     * If you went to pass specific information on what the courier should pick up, you may pass
     * an array of @link JobItem objects detailed below.
     *
     * @param JobItem[] $jobItems
     */
    public function setJobItems(array $jobItems): void
    {
        $this->_jobItems = $jobItems;
    }

    /**
     * Any special instructions may be specified here.
     *
     * @return string
     */
    public function getSpecialInstructions(): string
    {
        return $this->_specialInstructions;
    }

    /**
     * Any special instructions may be specified here.
     *
     * @param string $specialInstructions
     */
    public function setSpecialInstructions(string $specialInstructions): void
    {
        $this->_specialInstructions = $specialInstructions;
    }

    /**
     * Requires a photo be taken before a job can be marked delivered.
     *
     * @return bool
     */
    public function isRequirePhotoOnDelivery(): bool
    {
        return $this->_requirePhotoOnDelivery;
    }

    /**
     * Requires a photo be taken before a job can be marked delivered.
     *
     * @param bool $requirePhotoOnDelivery
     */
    public function setRequirePhotoOnDelivery(bool $requirePhotoOnDelivery): void
    {
        $this->_requirePhotoOnDelivery = $requirePhotoOnDelivery;
    }

    /**
     * A reference number for the courier to use. This will be displayed to the courier.
     *
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->_externalId;
    }

    /**
     * A reference number for the courier to use. This will be displayed to the courier.
     *
     * @param string $externalId
     */
    public function setExternalId(string $externalId): void
    {
        $this->_externalId = $externalId;
    }

    /**
     * Serialize the Job to TwinJet format
     *
     * @inheritDoc
     * $this->lastEaten->format(DateTime::ISO8601)
     *
     */
    public function jsonSerialize()
    {
        if (is_null($this->isLive()) ||
            is_null($this->_apiToken) ||
            is_null($this->_orderContactPhone) ||
            is_null($this->_readyTime) ||
            is_null($this->_deliverFromDateTime) ||
            is_null($this->_deliverToDateTime))
        {
            throw new JsonException("Required values are isLive, apiToken, readyTime, _deliverFromDateTime, _deliverToDateTime");
        }

        if ( is_null($this->_deliveryAddress) && is_null($this->_pickupAddress) )
        {
            throw new JsonException("Either pickupAddress or deliveryAddress are required.");
        }

        if(is_null($this->_orderTotal))
        {
            throw new JsonException("Order total was not specified");
        }

        return [
            'live' => $this->_isLive,
            'api_token' => $this->_apiToken,
            'order_contact_name'=>$this->_orderContactName,
            'order_contact_phone'=>$this->_orderContactPhone,
            'pick_address'=>$this->_pickupAddress,
            'deliver_address'=>$this->_deliveryAddress,
            'payment_method'=>$this->_paymentMethod,
            'ready_time'=>$this->_readyTime->format(DateTime::ISO8601),
            'deliver_from_time'=>$this->_deliverFromDateTime->format(DateTime::ISO8601),
            'deliver_to_time'=>$this->_deliverToDateTime->format(DateTime::ISO8601),
            'service_id'=>$this->_serviceId,
            'order_total'=>$this->_orderTotal,
            'tip'=>$this->_tip,
            'reference'=>$this->_reference,
            'external_id'=>$this->_externalId,
            'webhook_url'=>$this->_webhookUrl,
            'job_items'=>$this->_jobItems,
            'photo'=>$this->_requirePhotoOnDelivery,
            'special_instructions'=>$this->_specialInstructions,
        ];
    }

}
