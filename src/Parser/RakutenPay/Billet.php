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

namespace Rakuten\Connector\Parser\RakutenPay;

use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Billet as TransactionBillet;
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
        $response = self::getTransactionBillet();
        $data = json_decode($webservice->getResponse(), true);
        $payment = $data["payments"][0];

        return $response->setResult($data['result'])
            ->setChargeId($data['charge_uuid'])
            ->setBillet($payment['billet']['download_url'])
            ->setBilletUrl($payment['billet']['url'])
            ->setResultMessage(implode(' - ', $data['result_messages']));
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
