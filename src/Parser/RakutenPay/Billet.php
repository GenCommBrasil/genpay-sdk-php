<?php

namespace Rakuten\Connector\Parser\RakutenPay;

use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Billet as TransactionBillet;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\Parser;

/**
 * Class Billet
 * @package Rakuten\Connector\Parser\RakutenPay
 */
class Billet extends Error implements Parser
{
    /**
     * @return TransactionBillet
     */
    protected static function getTransactionBillet()
    {
        return new TransactionBillet();
    }

    /**
     * @param Webservice $webservice
     * @return TransactionBillet
     */
    public static function success(Webservice $webservice)
    {
        if ($webservice->getStatus() == Status::OK) {
            $response = self::getTransactionBillet();
            $data = json_decode($webservice->getResponse(), true);
            $payment = $data["payments"][0];

            return $response->setResult($data['result'])
                ->setChargeId($data['charge_uuid'])
                ->setBillet($payment['billet']['download_url'])
                ->setBilletUrl($payment['billet']['url']);
        }

        return self::error($webservice);
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
