<?php

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
}
