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
 * Class Billet
 * @package Rakuten\Connector\Parser\RakutenPay\Transaction
 */
class Billet
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
    private $billet;

    /**
     * @var string
     */
    private $billetUrl;

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * @return string
     */
    public function getBillet()
    {
        return $this->billet;
    }

    /**
     * @return string
     */
    public function getBilletUrl()
    {
        return $this->billetUrl;
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
     * @param $chargeId
     * @return $this
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;
        return $this;
    }

    /**
     * @param $billet
     * @return $this
     */
    public function setBillet($billet)
    {
        $this->billet = $billet;
        return $this;
    }

    /**
     * @param $billetUrl
     * @return $this
     */
    public function setBilletUrl($billetUrl)
    {
        $this->billetUrl = $billetUrl;
        return $this;
    }
}
