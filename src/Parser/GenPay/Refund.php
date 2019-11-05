<?php
/**
 ************************************************************************
 * Copyright [2019] [GenComm]
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

namespace GenComm\Parser\GenPay;

use GenComm\Parser\Error;
use GenComm\Service\Http\Webservice;
use GenComm\Parser\GenPay\Transaction\Refund as TransactionRefund;
use GenComm\Parser\Parser;

/**
 * Class Refund
 * @package GenComm\Parser\GenPay
 */
class Refund implements Parser
{
    /**
     * @return TransactionRefund
     */
    private static function getTransactionCancel()
    {
        return new TransactionRefund();
    }

    /**
     * @param Webservice $webservice
     * @return TransactionRefund
     */
    public static function success(Webservice $webservice)
    {
        $response = self::getTransactionCancel();
        $data = json_decode($webservice->getResponse()->getResult(), true);

        return $response->setStatus($data['status'])
            ->setChargeId($data['uuid'])
            ->setStatusHistory($data['status_history'])
            ->setRefunds($data['refunds'])
            ->setMessage('')
            ->setResponse($webservice->getResponse());
    }

    /**
     * @param Webservice $webservice
     * @return Error
     */
    public static function error(Webservice $webservice)
    {
        $error = new Error();
        $data = json_decode($webservice->getResponse()->getResult(), true);
        $code = isset($data['result_code']['code']) ? $data['result_code']['code'] : "";

        $error
            ->setCode($code)
            ->setMessage(implode(' - ', $data['result_messages']))
            ->setResponse($webservice->getResponse());

        return $error;
    }
}
