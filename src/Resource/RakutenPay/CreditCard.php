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

use Rakuten\Connector\Helper\StringFormat;
use stdClass;

/**
 * Class CreditCard
 * @package Rakuten\Resource\RakutenPay
 */
class CreditCard extends RakutenPayResource implements PaymentMethod
{
    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->options = new stdClass();
        $this->data->method = self::CREDIT_CARD;
        $this->setOptions();
    }
    /**
     * Set Options Default
     *
     * @void
     */
    protected function setOptions()
    {
        $this->data->options->save_card = false;
        $this->data->options->recurrency = false;
        $this->data->options->new_card = false;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->data->token = $token;

        return $this;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->data->reference = $reference;

        return $this;
    }

    /**
     * @param int $installmentsQuantity
     * @return $this
     */
    public function setInstallmentsQuantity($installmentsQuantity)
    {
        $this->data->installments_quantity = (int) $installmentsQuantity;

        return $this;
    }

    /**
     * @param string $holderName
     * @return $this
     */
    public function setHolderName($holderName)
    {
        $this->data->holder_name = $holderName;

        return $this;
    }

    /**
     * @param string $holderDocument
     * @return $this
     */
    public function setHolderDocument($holderDocument)
    {
        $this->data->holder_document = StringFormat::getOnlyNumbers($holderDocument);

        return $this;
    }

    /**
     * @param string $cvv
     * @return $this
     */
    public function setCvv($cvv)
    {
        $this->data->cvv = $cvv;

        return $this;
    }

    /**
     * @param string $brand
     * @return $this
     */
    public function setBrand($brand)
    {
        $this->data->brand = $brand;

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

    /**
     * Set Interest Installments only if you use interest
     *
     * @param int $quantity
     * @param float $interestPercent
     * @param float $interestAmount
     * @param float $installmentAmount
     * @param float $total
     */
    public function setInstallmentInterest($quantity, $interestPercent, $interestAmount, $installmentAmount, $total)
    {
        if (!isset($this->data->installments)) {
            $this->data->installments = new stdClass();
        }

        $this->data->installments->quantity = (int) $quantity;
        $this->data->installments->interest_percent = (float) $interestPercent;
        $this->data->installments->interest_amount = (float) $interestAmount;
        $this->data->installments->installment_amount = (float) $installmentAmount;
        $this->data->installments->total = (float) $total;
    }
}