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

namespace Rakuten\Connector;

use Rakuten\Connector\Enum\Endpoint;
use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Parser\RakutenPay\Authorization;
use Rakuten\Connector\Parser\RakutenPay\Checkout;
use Rakuten\Connector\Parser\RakutenPay\Factory;
use Rakuten\Connector\Resource\RakutenConnector;
use Rakuten\Connector\Resource\Credential;
use Rakuten\Connector\Resource\RakutenPay\Customer;
use Rakuten\Connector\Resource\RakutenPay\Order;
use Rakuten\Connector\Resource\RakutenPay\PaymentMethod;
use Rakuten\Connector\Resource\RakutenPay\Billet;
use Rakuten\Connector\Resource\RakutenPay\CreditCard;
use Rakuten\Connector\Resource\RakutenPay\Refund;
use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\Service\Http\Responsibility;
use Rakuten\Connector\Service\Http\Webservice;

/**
 * Class RakutenPay
 * @package Rakuten\Connector
 */
class RakutenPay extends RakutenConnector implements Credential
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
     * @return \Rakuten\Connector\Parser\RakutenPay\Transaction\Billet|
     * \Rakuten\Connector\Parser\RakutenPay\Transaction\CreditCard|
     * Error
     *
     * @throws RakutenException
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
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @return \Rakuten\Connector\Parser\RakutenPay\Transaction\Authorization|Error
     * @throws RakutenException
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
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @param $amount
     * @return \Rakuten\Connector\Parser\RakutenPay\Transaction\Checkout|Error
     * @throws RakutenException
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
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @param $chargeId
     * @param $requester
     * @param $reason
     * @return mixed
     * @throws RakutenException
     */
    public function cancel($chargeId, $requester, $reason)
    {
        try {
            $data = [
                'requester' => $requester,
                'reason' => $reason,
            ];
            $webservice = $this->getWebservice();
            $transaction = Factory::create('Rakuten\Connector\Parser\RakutenPay\Transaction\Refund');

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
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @param Refund $refund
     * @param $chargeId
     * @return mixed
     * @throws RakutenException
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
        } catch (RakutenException $e) {
            throw $e;
        }
    }

    /**
     * @param Refund $refund
     * @param $chargeId
     * @return mixed
     * @throws RakutenException
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
        } catch (RakutenException $e) {
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
