<?php
/**
 ************************************************************************
 * Copyright [2019] [GenComm]
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

namespace GenComm\Parser\GenLog\Transaction;

use GenComm\Parser\Transaction;
use GenComm\Service\Http\Response\Response;

/**
 * Class OrderDetail
 * @package GenComm\Parser\GenLog\Transaction
 */
class OrderDetail extends Transaction
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $calculationCode;

    /**
     * @var string
     */
    private $batchCode;

    /**
     * @var string
     */
    private $carrierType;

    /**
     * @var string
     */
    private $trackingUrl;

    /**
     * @var string
     */
    private $printUrl;

    /**
     * @var array
     */
    private $customer = [];

    /**
     * @var array
     */
    private $deliveryAddress = [];

    /**
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param $calculationCode
     * @return $this
     */
    public function setCalculationCode($calculationCode)
    {
        $this->calculationCode = $calculationCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCalculationCode()
    {
        return $this->calculationCode;
    }

    /**
     * @param $batchCode
     * @return $this
     */
    public function setBatchCode($batchCode)
    {
        $this->batchCode = $batchCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBatchCode()
    {
        return $this->batchCode;
    }

    /**
     * @param $carrierType
     * @return $this
     */
    public function setCarrierType($carrierType)
    {
        $this->carrierType = $carrierType;

        return $this;
    }

    /**
     * @return string
     */
    public function getCarrierType()
    {
        return $this->carrierType;
    }

    /**
     * @param $trackingUrl
     * @return $this
     */
    public function setTrackingUrl($trackingUrl)
    {
        $this->trackingUrl = $trackingUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrackingUrl()
    {
        return $this->trackingUrl;
    }

    /**
     * @param $printUrl
     * @return $this
     */
    public function setPrintUrl($printUrl)
    {
        $this->printUrl = $printUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrintUrl()
    {
        return $this->printUrl;
    }

    /**
     * @param array $customer
     * @return $this
     */
    public function setCustomer(array $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return array
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param array $deliveryAddress
     * @return $this
     */
    public function setDeliveryAddress(array $deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * @return array
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }
}
