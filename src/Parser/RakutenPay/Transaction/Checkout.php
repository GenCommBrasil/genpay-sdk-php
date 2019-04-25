<?php

namespace Rakuten\Connector\Parser\RakutenPay\Transaction;

/**
 * Class Checkout
 * @package Rakuten\Connector\Parser\RakutenPay\Transaction
 */
class Checkout
{
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
}
