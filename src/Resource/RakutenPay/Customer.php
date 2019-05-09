<?php
/**
 ************************************************************************
 * Copyright [2019] [RakutenConnector]
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ************************************************************************
 */

namespace Rakuten\Connector\Resource\RakutenPay;

use Rakuten\Connector\Enum\Address;
use Rakuten\Connector\Helper\StringFormat;
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
     * @param $countryCode
     * @param $areaCode
     * @param $number
     * @param $reference
     * @param $kind
     * @return $this
     */
    public function addAPhones($countryCode, $areaCode, $number, $reference, $kind)
    {
        $phone = new stdClass();
        $phone->number = new stdClass();
        $phone->number->country_code = $countryCode;
        $phone->number->area_code = $areaCode;
        $phone->number->number = $number;
        $phone->reference = $reference;
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
        $this->data->document = StringFormat::getOnlyNumbers($document);

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
