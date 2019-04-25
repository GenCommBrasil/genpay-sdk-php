<?php

namespace Rakuten\Connector\Resource\RakutenPay;

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
        $this->data->options->save_card = true;
        $this->data->options->recurrency = false;
        $this->data->options->new_card = true;
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
        $this->data->holder_document = $holderDocument;

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
     * @param float $quantity
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

        $this->data->installments->total = (float) $total;
        $this->data->installments->quantity = (float) $quantity;
        $this->data->installments->interest_percent = (float) $interestPercent;
        $this->data->installments->interest_amount = (float) $interestAmount;
        $this->data->installments->installment_amount = (float) $installmentAmount;
    }
}