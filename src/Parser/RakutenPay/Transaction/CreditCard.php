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

/**
 * Class CreditCard
 * @package Rakuten\Connector\Parser\RakutenPay\Transaction
 */
class CreditCard
{
    /**
     * @var string
     */
    private $result;

    /**
     * @var string
     */
    private $chargeId;

    /**
     * @var string
     */
    private $creditCardNum;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $resultMessage;

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;
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

    /**
     * @return string
     */
    public function getCreditCardNum()
    {
        return $this->creditCardNum;
    }

    /**
     * @param string $creditCardNum
     * @return $this
     */
    public function setCreditCardNum($creditCardNum)
    {
        $this->creditCardNum = $creditCardNum;
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
    public function getResultMessage()
    {
        return $this->resultMessage;
    }

    /**
     * @param string $resultMessage
     * @return $this
     */
    public function setResultMessage($resultMessage)
    {
        $this->resultMessage = $resultMessage;
        return $this;
    }
}
