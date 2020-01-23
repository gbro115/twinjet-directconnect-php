<?php


namespace TwinJet\models\constants;

use ReflectionClass;

/**
 * Class PaymentMethod
 * @package TwinJet\models\constants
 *
 * 	Payment method for the delivery, options:
 * INVOICE = 1 (no transaction at delivery)
 * CUSTOMER PREPAID = 2 (customer pre tips)
 * CUSTOMER CC = 4 (customer tips at delivery)
 * CUSTOMER CASH = 6
 *
 */
class PaymentMethod
{
    /**
     * No transaction at delivery
     */
    const INVOICE = 1;

    /**
     * Customer has already paid for the delivery (pre tips)
     */
    const CUSTOMER_PREPAID = 2;

    /**
     * Customer pays with card and tips at delivery
     */
    const CUSTOMER_CC = 4;

    /**
     * Cash on delivery
     */
    const CUSTOMER_CASH =6;

    /**
     * Get an array of the constants defined in the class.
     *
     * @return array
     * @throws \ReflectionException
     */
    static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}