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
use Rakuten\Connector\Parser\RakutenPay\Transaction\Authorization as TransactionAuthorization;
use Rakuten\Connector\Parser\Parser;

/**
 * Class Authorization
 * @package Rakuten\Connector\Parser\RakutenPay
 */
class Authorization implements Parser
{
    /**
     * @return TransactionAuthorization
     */
    protected static function getTransactionAuthorization()
    {
        return new TransactionAuthorization();
    }

    /**
     * @param Webservice $webservice
     * @return mixed|TransactionAuthorization
     */
    public static function success(Webservice $webservice)
    {
        $transaction = self::getTransactionAuthorization();
        $transaction
            ->setMessage(true)
            ->setResponse($webservice->getResponse());

        return $transaction;
    }

    /**
     * @param Webservice $webservice
     * @return Error
     */
    public static function error(Webservice $webservice)
    {
        $error = new Error();

        $error
            ->setCode($webservice->getResponse()->getStatus())
            ->setMessage($webservice->getResponse()->getResult())
            ->setResponse($webservice->getResponse());

        return $error;
    }
}
