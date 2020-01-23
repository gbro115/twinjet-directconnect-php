<?php


namespace TwinJet\models;


use JsonException;
use JsonSerializable;
use function is_null;

/**
 * Class JobItem
 * @package TwinJet\models
 */
class JobItem implements JsonSerializable
{
    protected $_quantity;
    protected $_description;
    protected $_sku;

    /**
     * The quantity of the job item
     *
     * @return integer
     */
    public function getQuantity(): integer
    {
        return $this->_quantity;
    }

    /**
     * The quantity of the job item
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->_quantity = $quantity;
    }

    /**
     * A description of the item being picked up
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * A description of the item being picked up
     *
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->_description = $description;
    }

    /**
     * A SKU/Id of the item being picked up.
     *
     * @return string
     */
    public function getSku(): string
    {
        return $this->_sku;
    }

    /**
     * A SKU/Id of the item being picked up.
     *
     * @param string $sku
     */
    public function setSku($sku): void
    {
        $this->_sku = $sku;
    }

    /**
     * Convert this JobItem into a JSON object compliant with TwinJet's requirements.
     *
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        if(is_null($this->_quantity))
        {
            throw new JsonException("quantity is a required value");
        }

        return [
            'quantity'=>$this->_quantity,
            'description'=>$this->_description,
            'sku'=>$this->_sku
        ];
    }
}