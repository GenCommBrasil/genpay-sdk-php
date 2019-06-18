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

namespace Rakuten\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Environment;
use Rakuten\Connector\Resource\RakutenPay\Billet;
use Rakuten\Connector\Resource\RakutenPay\CreditCard;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Resource\RakutenPay\Customer;
use Rakuten\Connector\Resource\RakutenPay\Order;
use Rakuten\Connector\Service\Http\Response\Response;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Enum\Status;

class RakutenPayTest extends TestCase
{
    public function testItShouldReturnObjectsInMethods()
    {
        $rakutenPay = new RakutenPay(
            "fake-document",
            "fake-apikey",
            "fake-signature",
            Environment::SANDBOX);
        $order = $rakutenPay->order();
        $customer = $rakutenPay->customer();
        $billet = $rakutenPay->asBillet();
        $crediCard = $rakutenPay->asCreditCard();

        $this->assertInstanceOf(Order::class, $order,"Return Order Object");
        $this->assertInstanceOf(Customer::class, $customer,"Return Customer Object");
        $this->assertInstanceOf(Billet::class, $billet,"Return Billet Object");
        $this->assertInstanceOf(CreditCard::class, $crediCard,"Return Credit Card Object");
    }

    public function testItShouldCreateOrderAsBillet()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getPayload());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post')
            ->willReturn($this->getPayload());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubRakutenPay = $this->getMockBuilder(RakutenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $order = $stubRakutenPay->order();
        $customer = $stubRakutenPay->customer();
        $payment = $stubRakutenPay->asBillet();

        $stubRakutenPay->createOrder($order, $customer, $payment);
    }

    public function testItShouldCreateOrderAsBilletReturnExceptionError()
    {
        $response = new Response();
        $response->setStatus('');
        $response->setResult('');

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post');
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);


        $stubRakutenPay = $this->getMockBuilder(RakutenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $this->expectExceptionMessage("Unknown Error in Responsibility:  - Status:");

        $order = $stubRakutenPay->order();
        $customer = $stubRakutenPay->customer();
        $payment = $stubRakutenPay->asBillet();

        $stubRakutenPay->createOrder($order, $customer, $payment);
    }

    public function testItShouldGetInstallmentsInterestForCheckoutAndReturnSuccess()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getDataInstallments());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('get')
            ->willReturn($this->getDataInstallments());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubRakutenPay = $this->getMockBuilder(RakutenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $stubRakutenPay->checkout(1000);
    }

    public function testItShouldGetInstallmentsInterestForCheckoutAndReturnException()
    {
        $response = new Response();
        $response->setStatus('');
        $response->setResult('');

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('get');
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubRakutenPay = $this->getMockBuilder(RakutenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $this->expectExceptionMessage("Unknown Error in Responsibility:  - Status:");

        $stubRakutenPay->checkout(1000);
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return '
        {
          "shipping": {
            "time": null,
            "kind": null,
            "company": null,
            "amount": 0.0,
            "adjustments": []
          },
          "result_messages": [],
          "result": "success",
          "reference": "SDK-1",
          "payments": [
            {
              "status": "authorized",
              "result_messages": [],
              "result": "success",
              "refundable_amount": 200.0,
              "reference": "",
              "method": "billet",
              "id": "db54844c-b630-45f8-8d24-b818fb9b7cef",
              "billet": {
                "url": "https://api-sandbox.rakutenpay.com.br/v1/billets/db54844c-b630-45f8-8d24-b818fb9b7cef",
                "number": "5093454",
                "download_url": "http://oneapi-sandbox.rakutenpay.com.br/sandbox/rpay/v1/charges/4d0a36a0-19ed-49de-8148-645bb7cc9840/billet/download"
              },
              "amount": 200.0
            }
          ],
          "fingerprint": "fake-fingerprint",
          "commissionings": [],
          "charge_uuid": "4d0a36a0-19ed-49de-8148-645bb7cc9840"
        }';
    }

    /**
     * @return string
     */
    protected function getDataInstallments()
    {
        $jsonSuccess = '
        {
           "result":"success",
           "payments":[
              {
                 "method":"credit_card",
                 "installments":[
                    {
                       "total":5149.5,
                       "quantity":1,
                       "interest_percent":2.99,
                       "interest_amount":149.5,
                       "installment_amount":5149.5
                    },
                    {
                       "total":5226.5,
                       "quantity":2,
                       "interest_percent":4.53,
                       "interest_amount":226.5,
                       "installment_amount":2613.25
                    },
                    {
                       "total":5304.51,
                       "quantity":3,
                       "interest_percent":6.09,
                       "interest_amount":304.51,
                       "installment_amount":1768.17
                    },
                    {
                       "total":5385.0,
                       "quantity":4,
                       "interest_percent":7.7,
                       "interest_amount":385.0,
                       "installment_amount":1346.25
                    },
                    {
                       "total":5466.5,
                       "quantity":5,
                       "interest_percent":9.33,
                       "interest_amount":466.5,
                       "installment_amount":1093.3
                    },
                    {
                       "total":5548.02,
                       "quantity":6,
                       "interest_percent":10.96,
                       "interest_amount":548.02,
                       "installment_amount":924.67
                    },
                    {
                       "total":5631.5,
                       "quantity":7,
                       "interest_percent":12.63,
                       "interest_amount":631.5,
                       "installment_amount":804.5
                    },
                    {
                       "total":5722.0,
                       "quantity":8,
                       "interest_percent":14.44,
                       "interest_amount":722.0,
                       "installment_amount":715.25
                    },
                    {
                       "total":5809.5,
                       "quantity":9,
                       "interest_percent":16.19,
                       "interest_amount":809.5,
                       "installment_amount":645.5
                    },
                    {
                       "total":5900.5,
                       "quantity":10,
                       "interest_percent":18.01,
                       "interest_amount":900.5,
                       "installment_amount":590.05
                    },
                    {
                       "total":5983.01,
                       "quantity":11,
                       "interest_percent":19.66,
                       "interest_amount":983.01,
                       "installment_amount":543.91
                    },
                    {
                       "total":6082.56,
                       "quantity":12,
                       "interest_percent":21.65,
                       "interest_amount":1082.56,
                       "installment_amount":506.88
                    }
                 ],
                 "cards":[
        
                 ],
                 "brands":[
                    "visa",
                    "mastercard",
                    "diners",
                    "hipercard",
                    "amex",
                    "elo"
                 ],
                 "amount":5.0e3
              },
              {
                 "method":"billet",
                 "amount":5.0e3
              }
           ]
        }';

        return $jsonSuccess;
    }
}