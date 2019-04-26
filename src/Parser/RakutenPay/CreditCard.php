<?php

namespace Rakuten\Connector\Parser\RakutenPay;

use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Parser\RakutenPay\Transaction\CreditCard as TransactionCreditCard;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\Parser;

/**
 * Class CreditCard
 * @package Rakuten\Connector\Parser\RakutenPay
 */
class CreditCard implements Parser
{
    /**
     * @return TransactionCreditCard
     */
    private static function getTransactionCreditCard()
    {
        return new TransactionCreditCard();
    }

    /**
     * @param Webservice $webservice
     * @return TransactionCreditCard
     */
    public static function success(Webservice $webservice)
    {
        $response = self::getTransactionCreditCard();
        $data = json_decode($webservice->getResponse(), true);

        $payment = $data["payments"][0];

        return $response->setResult($data['result'])
            ->setChargeId($data['charge_uuid'])
            ->setCreditCardNum($payment['credit_card']['number'])
            ->setStatus($payment['status']);
    }

    /**
     * @param Webservice $webservice
     * @return Error
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
