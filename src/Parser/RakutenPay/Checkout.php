<?php

namespace Rakuten\Connector\Parser\RakutenPay;

use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Checkout as TransactionCheckout;
use Rakuten\Connector\Parser\Parser;

/**
 * Class Checkout
 * @package Rakuten\Connector\Parser\RakutenPay
 */
class Checkout extends Error implements Parser
{
    /**
     * @return TransactionCheckout
     */
    protected static function getTransactionCheckout()
    {
        return new TransactionCheckout();
    }

    /**
     * @param Webservice $webservice
     * @return mixed|Error|TransactionCheckout
     */
    public static function success(Webservice $webservice)
    {
        $response = self::getTransactionCheckout();
        $data = json_decode($webservice->getResponse(), true);
        $payments = array_shift($data['payments']);

        $response->setResult($data['result'])
            ->setMethod($payments['method'])
            ->setInstallments($payments['installments']);

        return $response;
    }

    /**
     * @param Webservice $webservice
     * @return mixed|Error
     */
    public static function error(Webservice $webservice)
    {
        $error = new Error();
        $data = json_decode($webservice->getResponse(), true);

        $error->setCode($webservice->getStatus())
            ->setMessage(implode(' - ', $data['result_messages']));

        return $error;
    }
}
