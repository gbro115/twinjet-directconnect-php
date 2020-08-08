<?php


namespace TwinJet\models;

use InvalidArgumentException;
use JsonException;
use JsonSerializable;
use function is_null;
use function preg_replace;
use function strlen;

class Address implements JsonSerializable
{
    protected $_addressName;
    protected $_streetAddress;
    protected $_floor;
    protected $_city;
    protected $_state;
    protected $_zipCode;
    protected $_contact;
    protected $_phoneNumber;
    protected $_specialInstructions;

    /**
     * The "Line 1" of an address. Typically the company name, or recipient name.
     *
     * @return string
     */
    public function getAddressName()
    {
        return $this->_addressName;
    }

    /**
     * The "Line 1" of an address. Typically the company name, or recipient name.
     *
     * @param string $address_name
     */
    public function setAddressName($address_name): void
    {
        $this->_addressName = $address_name;
    }

    /**
     * The house number + street name
     *
     * @example 565 Ellis St
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->_streetAddress;
    }

    /**
     * The house number + street name
     *
     * @example 565 Ellis St
     * @param string $street_address
     */
    public function setStreetAddress($street_address): void
    {
        $this->_streetAddress = $street_address;
    }

    /**
     * Floor/Suite Number/Apartment Number/Unit
     *
     * @return string
     */
    public function getFloor()
    {
        return $this->_floor;
    }

    /**
     * Floor/Suite Number/Apartment Number/Unit
     *
     * @param string $floor
     */
    public function setFloor($floor): void
    {
        $this->_floor = $floor;
    }

    /**
     * The city name
     *
     * @return mixed
     */
    public function getCity(): string
    {
        return $this->_city;
    }

    /**
     * The city name
     *
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->_city = $city;
    }

    /**
     * The two letter USPS state abbreviation
     *
     * @example CA
     * @return string
     */
    public function getState(): string
    {
        return $this->_state;
    }

    /**
     * The two letter USPS state abbreviation
     *
     * @example CA
     * @param mixed $state
     */
    public function setState($state): void
    {
        $trimmedState = preg_replace('/\s/', '', $state);
        if( strlen($trimmedState) > 2 )
        {
            throw new InvalidArgumentException("Attempted to set state to a value longer than 2 characters [$trimmedState]");
        }
        $this->_state = $trimmedState;
    }

    /**
     * The 5 digit USPS zip code for the address. Do not pass the zip+4, 5 character limit.
     *
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->_zipCode;
    }

    /**
     * The 5 digit USPS zip code for the address. Do not pass the zip+4, 5 character limit.
     *
     * @param string $zip_code
     */
    public function setZipCode($zip_code): void
    {
        $trimmedZip = preg_replace('/\s/', '', $zip_code);
        if( strlen($trimmedZip) > 6 )
        {
            throw new InvalidArgumentException("Attempted to set zip code to a string longer than the limit of 6 characters [$trimmedZip]");
        }
        $this->_zipCode = $trimmedZip;
    }

    /**
     * A contact person located at the address.
     *
     * @return string
     */
    public function getContact(): string
    {
        return $this->_contact;
    }

    /**
     * A contact person located at the address.
     *
     * @param string $contact
     */
    public function setContact($contact): void
    {
        $this->_contact = $contact;
    }

    /**
     * A contact phone number for somebody at the address.
     *
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->_phoneNumber;
    }

    /**
     * A contact phone number for somebody at the address.
     *
     * @param string $phone_number
     */
    public function setPhoneNumber($phone_number): void
    {
        $this->_phoneNumber = $phone_number;
    }

    /**
     * Any address specific delivery instructions.
     *
     * @return string
     */
    public function getSpecialInstructions(): string
    {
        return $this->_specialInstructions;
    }

    /**
     * Any address specific delivery instructions.
     *
     * @param string $special_instructions
     */
    public function setSpecialInstructions($special_instructions): void
    {
        $this->_specialInstructions = $special_instructions;
    }


    /**
     * Convert the Address into a JSON object in TwinJet format
     *
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        if(is_null($this->_streetAddress) || is_null($this->_state) || is_null($this->_city) || is_null($this->_zipCode))
        {
            throw new JsonException("Required fields are streetAddress, state, city and zipCode");
        }

        return [
            'address_name' => $this->_addressName,
            'street_address' => $this->_streetAddress,
            'floor'=>$this->_floor,
            'city'=>$this->_city,
            'state'=>$this->_state,
            'zip_code'=>$this->_zipCode,
            'contact'=>$this->_contact,
            'phone_number'=>$this->_phoneNumber,
            'special_instructions'=>$this->_specialInstructions
        ];
    }
}