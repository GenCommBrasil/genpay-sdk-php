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

use Rakuten\Connector\Resource\Resource;
use stdClass;

/**
 * Class Refund
 * @package Rakuten\Connector\Resource\RakutenPay
 */
class Refund extends Resource
{
    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data = new stdClass();
    }

    /**
     * @param $requester
     * @return $this
     */
    public function setRequester($requester)
    {
        $this->data->requester = $requester;

        return $this;
    }

    /**
     * @param $reason
     * @return $this
     */
    public function setReason($reason)
    {
        $this->data->reason = $reason;

        return $this;
    }

    /**
     * @param string $id
     * @param float $amount
     * @param array $bankAccount
     * @return $this
     */
    public function addPayment($id, $amount, array $bankAccount = [])
    {
        $payment = new stdClass();
        $payment->id = $id;
        $payment->amount = (float) $amount;

        if (count($bankAccount)) {
            $payment->bank_account = $bankAccount;
        }

        if (!isset($this->data->payments)) {
            $this->data->payments = [];
        }

        $this->data->payments[] = $payment;

        return $this;
    }
}
