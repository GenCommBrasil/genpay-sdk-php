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
 * Class Calculation
 * @package GenComm\Parser\GenLog\Transaction
 */
class Calculation extends Transaction
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
    private $ownerCode;

    /**
     * @var string
     */
    private $expirationDate;

    /**
     * @var array
     */
    private $shippingOptions = [];

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
     * @param $ownerCode
     * @return $this
     */
    public function setOwnerCode($ownerCode)
    {
        $this->ownerCode = $ownerCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getOwnerCode()
    {
        return $this->ownerCode;
    }

    /**
     * @param $expirationDate
     * @return $this
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param array $shippingOptions
     * @return $this
     */
    public function setShippingOptions(array $shippingOptions)
    {
        $this->shippingOptions = $shippingOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function getShippingOptions()
    {
        return $this->shippingOptions;
    }
}
