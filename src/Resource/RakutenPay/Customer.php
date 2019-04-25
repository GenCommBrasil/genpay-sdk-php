<?php

namespace Rakuten\Connector\Resource\RakutenPay;

use Rakuten\Connector\Enum\Address;
use stdClass;

/**
 * Class Customer
 * @package Rakuten\Connector\Resource\RakutenPay
 */
class Customer extends RakutenPayResource
{
    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->addresses = [];
        $this->data->phones = [];
    }

    /**
     * Add a new address to the customer.
     *
     * @param $kind
     * @param $zipcode
     * @param $street
     * @param $number
     * @param $district
     * @param $city
     * @param $state
     * @param $contact
     * @param null $complement
     * @return $this;
     */
    public function addAddress($kind, $zipcode, $street, $number, $district, $city, $state, $contact, $complement = null)
    {
        $address = new stdClass();
        $address->kind = $kind;
        $address->zipcode = $zipcode;
        $address->street = $street;
        $address->number = $number;
        $address->complement = $complement;
        $address->district = $district;
        $address->city = $city;
        $address->state = $state;
        $address->contact = $contact;
        $address->country = Address::ADDRESS_COUNTRY;
        $this->data->addresses[] = $address;

        return $this;
    }

    /**
     * @param $reference
     * @param $number
     * @param $countryCode
     * @param $areaCode
     * @param $kind
     * @return $this
     */
    public function addAPhones($reference, $number, $countryCode, $areaCode, $kind)
    {
        $phone = new stdClass();
        $phone->number = new stdClass();
        $phone->reference = $reference;
        $phone->number->number = $number;
        $phone->number->country_code = $countryCode;
        $phone->number->area_code = $areaCode;
        $phone->kind = $kind;
        $this->data->phones[] = $phone;

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->data->name = $name;

        return $this;
    }

    /**
     * @param $kind
     * @return $this
     */
    public function setKind($kind)
    {
        $this->data->kind = $kind;

        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->data->email = $email;

        return $this;
    }

    /**
     * @param $document
     * @return $this
     */
    public function setDocument($document)
    {
        $this->data->document = $document;

        return $this;
    }

    /**
     * @param $businessName
     * @return $this
     */
    public function setBusinessName($businessName)
    {
        $this->data->business_name = $businessName;

        return $this;
    }

    /**
     * @param $birthDate
     * @return $this
     */
    public function setBirthDate($birthDate)
    {
        $this->data->birth_date = $birthDate;

        return $this;
    }
}
