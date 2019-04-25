<?php

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
