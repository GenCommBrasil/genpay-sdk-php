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

namespace Rakuten\Connector\Parser\RakutenPay\Transaction;

use Rakuten\Connector\Parser\Transaction;
use Rakuten\Connector\Service\Http\Response\Response;

/**
 * Class Checkout
 * @package Rakuten\Connector\Parser\RakutenPay\Transaction
 */
class Checkout implements Transaction
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $result;

    /**
     * @var array
     */
    private $installments = [];

    /**
     * @var string
     */
    private $method;

    /**
     * @var Response
     */
    private $response;

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
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return array
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @param array $installments
     * @return $this
     */
    public function setInstallments(array $installments)
    {
        $this->installments = $installments;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

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
}
