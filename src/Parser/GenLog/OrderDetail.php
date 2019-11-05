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

namespace GenComm\Parser\GenLog;

use GenComm\Parser\Error;
use GenComm\Service\Http\Webservice;
use GenComm\Parser\GenLog\Transaction\OrderDetail as TransactionOrderDetail;
use GenComm\Parser\Parser;

/**
 * Class OrderDetail
 * @package GenComm\Parser\GenLog
 */
class OrderDetail implements Parser
{
    /**
     * @return TransactionOrderDetail
     */
    protected static function getTransactionOrderDetail()
    {
        return new TransactionOrderDetail();
    }

    /**
     * @param Webservice $webservice
     * @return TransactionOrderDetail
     */
    public static function success(Webservice $webservice)
    {
        $response = self::getTransactionOrderDetail();
        $data = json_decode($webservice->getResponse()->getResult(), true);
        $content = $data['content'];

        return $response->setStatus($data['status'])
            ->setCode($content['code'])
            ->setCalculationCode($content['calculation_code'])
            ->setBatchCode($content['batch_code'])
            ->setTrackingUrl($content['tracking_print_url'])
            ->setPrintUrl($content['batch_print_url'])
            ->setCarrierType($content['carrier_type'])
            ->setDeliveryAddress($content['delivery_address'])
            ->setCustomer($content['customer'])
            ->setMessage(implode(' - ', $data['messages']))
            ->setResponse($webservice->getResponse());
    }

    /**
     * @param Webservice $webservice
     * @return Error
     */
    public static function error(Webservice $webservice)
    {
        $error = new Error();
        $newMessages = [];

        $data = json_decode($webservice->getResponse()->getResult(), true);
        $code = $data['status'];
        $messages = $data['messages'];

        foreach ($messages as $message) {
            $newMessages[] = $message['text'];
        }

        $error
            ->setCode($code)
            ->setMessage(implode(' - ', $newMessages))
            ->setResponse($webservice->getResponse());

        return $error;
    }
}
