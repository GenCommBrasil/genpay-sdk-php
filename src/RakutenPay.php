<?php

namespace Rakuten\Connector;

use Rakuten\Connector\Enum\Endpoint;
use Rakuten\Connector\Parser\RakutenPay\Checkout;
use Rakuten\Connector\Parser\RakutenPay\ParserFactory;
use Rakuten\Connector\Resource\RakutenConnector;
use Rakuten\Connector\Resource\Credential;
use Rakuten\Connector\Resource\RakutenPay\Customer;
use Rakuten\Connector\Resource\RakutenPay\Order;
use Rakuten\Connector\Resource\RakutenPay\PaymentMethod;
use Rakuten\Connector\Resource\RakutenPay\Billet;
use Rakuten\Connector\Resource\RakutenPay\CreditCard;
use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\Service\Http\Responsibility;
use Rakuten\Connector\Service\Http\Webservice;

class RakutenPay extends RakutenConnector implements Credential
{
    /**
     * @var \stdClass
     */
    private $data;

    /**
     * @param $amount
     * @return mixed
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
     * @param Order $order
     * @param Customer $customer
     * @param PaymentMethod $payment
     * @return mixed
     * @throws RakutenException
     */
    public function createOrder(Order $order, Customer $customer, PaymentMethod $payment)
    {
        $this->data = $order->getData();
        $this->data->customer = $customer->getData();
        $this->data->payments[] = $payment->getData();

        try {
            $transaction = ParserFactory::create(get_class($payment));
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
     * @return Webservice
     */
    protected function getWebservice()
    {
        return new Webservice($this);
    }
}
