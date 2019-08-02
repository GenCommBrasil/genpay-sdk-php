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

namespace Rakuten\Connector\Resource\RakutenLog;

use Rakuten\Connector\Resource\Resource;
use stdClass;

/**
 * Class Batch
 * @package Rakuten\Connector\Resource\RakutenLog
 */
class Batch extends Resource
{
    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data->order = new stdClass();
        $this->data->order->customer = new stdClass();
        $this->data->order->delivery_address = new stdClass();
    }

    /**
     * @param $calculationCode
     * @return $this
     */
    public function setCalculationCode($calculationCode)
    {
        $this->data->calculation_code = $calculationCode;

        return $this;
    }

    /**
     * @param $postageServiceCode
     * @return $this
     */
    public function setPostageServiceCode($postageServiceCode)
    {
        $this->data->postage_service_code = $postageServiceCode;

        return $this;
    }

    /**
     * @param $code
     * @param $customerOrderNumber
     * @param $paymentsChargeId
     * @param $totalValue
     * @return $this
     */
    public function setOrder($code, $customerOrderNumber, $totalValue, $paymentsChargeId = null)
    {
        $this->data->order->code = $code;
        $this->data->order->customer_order_number = $customerOrderNumber;
        $this->data->order->charge_external_payments = false;
        $this->data->order->total_value = $totalValue;

        if (!is_null($paymentsChargeId)) {
            $this->data->order->payments_charge_id = $paymentsChargeId;
        }

        return $this;
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $document
     * @return $this
     */
    public function setCustomer($firstName, $lastName, $document)
    {
        $this->data->order->customer->first_name = $firstName;
        $this->data->order->customer->last_name = $lastName;
        $this->data->order->customer->cpf = $document;

        return $this;
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $street
     * @param $number
     * @param $complement
     * @param $district
     * @param $city
     * @param $state
     * @param $zipcode
     * @param $email
     * @param $phone
     * @param $fax
     * @return $this
     */
    public function setDeliveryAddress(
        $firstName,
        $lastName,
        $street,
        $number,
        $complement,
        $district,
        $city,
        $state,
        $zipcode,
        $email,
        $phone,
        $fax
    )
    {
        $this->data->order->delivery_address->first_name = $firstName;
        $this->data->order->delivery_address->last_name = $lastName;
        $this->data->order->delivery_address->street = $street;
        $this->data->order->delivery_address->number = $number;
        $this->data->order->delivery_address->complement = $complement;
        $this->data->order->delivery_address->district = $district;
        $this->data->order->delivery_address->city = $city;
        $this->data->order->delivery_address->state = $state;
        $this->data->order->delivery_address->zipcode = $zipcode;
        $this->data->order->delivery_address->email = $email;
        $this->data->order->delivery_address->phone = $phone;
        $this->data->order->delivery_address->fax = $fax;

        return $this;
    }
}
