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

namespace GenComm\Resource\GenPay;

use GenComm\Resource\Resource;
use stdClass;

/**
 * Class Billet
 * @package GenComm\Resource\GenPay
 */
class Billet extends Resource implements PaymentMethod
{
    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->method = self::BILLET;
    }

    /**
     * @param string $expiresOn
     * @return $this
     */
    public function setExpiresOn($expiresOn)
    {
        $this->data->expires_on = $expiresOn;

        return $this;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->data->amount = (float) $amount;

        return $this;
    }
}
