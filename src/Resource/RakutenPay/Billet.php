<?php

namespace Rakuten\Connector\Resource\RakutenPay;

use stdClass;

/**
 * Class Billet
 * @package Rakuten\Resource\RakutenPay
 */
class Billet extends RakutenPayResource implements PaymentMethod
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
