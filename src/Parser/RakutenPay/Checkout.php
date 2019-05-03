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
            ->setStatus($webservice->getStatus())
            ->setMethod($payments['method'])
            ->setInstallments($payments['installments'])
            ->setMessage('');

        return $response;
    }

    /**
     * @param Webservice $webservice
     * @return Error
     */
    public static function error(Webservice $webservice)
    {
        $error = new Error();
        $data = json_decode($webservice->getResponse(), true);

        $error->setStatus($webservice->getStatus())
            ->setCode($webservice->getStatus())
            ->setMessage(implode(' - ', $data['result_messages']));

        return $error;
    }
}
