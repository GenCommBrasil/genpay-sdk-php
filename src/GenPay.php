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

namespace GenComm;

use GenComm\Enum\Endpoint;
use GenComm\Parser\Error;
use GenComm\Parser\GenPay\Authorization;
use GenComm\Parser\GenPay\Checkout;
use GenComm\Parser\GenPay\Factory;
use GenComm\Resource\GenComm;
use GenComm\Resource\Credential;
use GenComm\Resource\GenPay\Customer;
use GenComm\Resource\GenPay\Order;
use GenComm\Resource\GenPay\PaymentMethod;
use GenComm\Resource\GenPay\Billet;
use GenComm\Resource\GenPay\CreditCard;
use GenComm\Resource\GenPay\Refund;
use GenComm\Exception\GenCommException;
use GenComm\Service\Http\Responsibility;
use GenComm\Service\Http\Webservice;

/**
 * Class GenPay
 * @package GenComm
 */
class GenPay extends GenComm implements Credential
{
    /**
     * @var \stdClass
     */
    private $data;

    /**
     * @return Order
     */
    public function order()
    {
        return new Order($this);
    }

    /**
     * @return Customer
     */
    public function customer()
    {
        return new Customer($this);
    }

    /**
     * @return Billet
     */
    public function asBillet()
    {
        return new Billet($this);
    }

    /**
     * @return CreditCard
     */
    public function asCreditCard()
    {
        return new CreditCard($this);
    }

    /**
     * @return Refund
     */
    public function asRefund()
    {
        return new Refund($this);
    }

    /**
     * @param Order $order
     * @param Customer $customer
     * @param PaymentMethod $payment
     *
     * @return \GenComm\Parser\GenPay\Transaction\Billet|
     * \GenComm\Parser\GenPay\Transaction\CreditCard|
     * Error
     *
     * @throws GenCommException
     */
    public function createOrder(Order $order, Customer $customer, PaymentMethod $payment)
    {
        $this->data = $order->getData();
        $this->data->customer = $customer->getData();
        $this->data->payments[] = $payment->getData();

        try {
            $transaction = Factory::create(get_class($payment));
            $webservice = $this->getWebservice();

            $data = json_encode($this->data, JSON_PRESERVE_ZERO_FRACTION);
            $webservice->post(
                Endpoint::createChargeUrl($this->getEnvironment()),
                $data
            );

            $response = Responsibility::http(
                $webservice,
                $transaction
            );

            return $response;
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @return \GenComm\Parser\GenPay\Transaction\Authorization|Error
     * @throws GenCommException
     */
    public function authorizationValidate()
    {
        try {
            $webservice = $this->getWebservice();
            $webservice->get(Endpoint::authorizationUrl($this->getEnvironment()));

            $response = Responsibility::http(
                $webservice,
                new Authorization()
            );

            return $response;
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @param $amount
     * @return \GenComm\Parser\GenPay\Transaction\Checkout|Error
     * @throws GenCommException
     */
    public function checkout($amount)
    {
        try {
            $webservice = $this->getWebservice();
            $url = sprintf(
                "%s?%s",
                Endpoint::buildCheckoutUrl($this->getEnvironment()),
                sprintf("%s=%s", "amount", $amount)
            );
            $webservice->get($url);
            $response = Responsibility::http($webservice, new Checkout());

            return $response;
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @param $chargeId
     * @param $requester
     * @param $reason
     * @return mixed
     * @throws GenCommException
     */
    public function cancel($chargeId, $requester, $reason)
    {
        try {
            $data = [
                'requester' => $requester,
                'reason' => $reason,
            ];
            $webservice = $this->getWebservice();
            $transaction = Factory::create('GenComm\Parser\GenPay\Transaction\Refund');

            $data = json_encode($data, JSON_PRESERVE_ZERO_FRACTION);
            $webservice->post(
                Endpoint::buildCancelUrl($this->getEnvironment(), $chargeId),
                $data
            );

            $response = Responsibility::http(
                $webservice,
                $transaction
            );

            return $response;
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @param Refund $refund
     * @param $chargeId
     * @return mixed
     * @throws GenCommException
     */
    public function refund(Refund $refund, $chargeId)
    {
        $this->data = $refund->getData();
        try {
            $webservice = $this->getWebservice();
            $transaction = Factory::create(get_class($refund));

            $data = json_encode($this->data, JSON_PRESERVE_ZERO_FRACTION);
            $webservice->post(
                Endpoint::buildRefundUrl($this->getEnvironment(), $chargeId),
                $data
            );

            $response = Responsibility::http(
                $webservice,
                $transaction
            );

            return $response;
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @param Refund $refund
     * @param $chargeId
     * @return mixed
     * @throws GenCommException
     */
    public function refundPartial(Refund $refund, $chargeId)
    {
        $this->data = $refund->getData();
        try {
            $webservice = $this->getWebservice();
            $transaction = Factory::create(get_class($refund));

            $data = json_encode($this->data, JSON_PRESERVE_ZERO_FRACTION);
            $webservice->post(
                Endpoint::buildRefundPartialUrl($this->getEnvironment(), $chargeId),
                $data
            );

            $response = Responsibility::http(
                $webservice,
                $transaction
            );

            return $response;
        } catch (GenCommException $e) {
            throw $e;
        }
    }

    /**
     * @return Webservice
     */
    protected function getWebservice()
    {
        return new Webservice($this);
    }
}
