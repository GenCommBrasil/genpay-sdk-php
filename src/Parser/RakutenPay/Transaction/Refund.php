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
 * Class Refund
 * @package Rakuten\Connector\Parser\RakutenPay\Transaction
 */
class Refund implements Transaction
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var array
     */
    private $statusHistory;

    /**
     * @var array
     */
    private $refunds;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $chargeId;

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
     * @param string $status
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
     * @return array
     */
    public function getStatusHistory()
    {
        return $this->statusHistory;
    }

    /**
     * @param $statusHistory
     * @return $this
     */
    public function setStatusHistory(array $statusHistory)
    {
        $this->statusHistory = $statusHistory;
        return $this;
    }

    /**
     * @return array
     */
    public function getRefunds()
    {
        return $this->refunds;
    }

    /**
     * @param $refunds
     * @return $this
     */
    public function setRefunds(array $refunds)
    {
        $this->refunds = $refunds;
        return $this;
    }

    /**
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * @param string $chargeId
     * @return $this
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;
        return $this;
    }
}
