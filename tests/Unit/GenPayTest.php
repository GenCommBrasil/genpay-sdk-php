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

namespace GenComm\Tests\Unit;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Environment;
use GenComm\Enum\Refund\Requester;
use GenComm\Resource\GenPay\Billet;
use GenComm\Resource\GenPay\CreditCard;
use GenComm\GenPay;
use GenComm\Resource\GenPay\Customer;
use GenComm\Resource\GenPay\Order;
use GenComm\Service\Http\Response\Response;
use GenComm\Service\Http\Webservice;
use GenComm\Enum\Status;

class GenPayTest extends TestCase
{
    public function testItShouldReturnObjectsInMethods()
    {
        $genPay = new GenPay(
            "fake-document",
            "fake-apikey",
            "fake-signature",
            Environment::SANDBOX);
        $order = $genPay->order();
        $customer = $genPay->customer();
        $billet = $genPay->asBillet();
        $crediCard = $genPay->asCreditCard();

        $this->assertInstanceOf(Order::class, $order,"Return Order Object");
        $this->assertInstanceOf(Customer::class, $customer,"Return Customer Object");
        $this->assertInstanceOf(Billet::class, $billet,"Return Billet Object");
        $this->assertInstanceOf(CreditCard::class, $crediCard,"Return Credit Card Object");
    }

    public function testItShouldCreateOrderAsBillet()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getResultCreateOrder());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post')
            ->willReturn($this->getResultCreateOrder());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $order = $stubGenPay->order();
        $customer = $stubGenPay->customer();
        $payment = $stubGenPay->asBillet();

        $stubGenPay->createOrder($order, $customer, $payment);
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


        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $this->expectExceptionMessage("Unknown Error in Responsibility:  - Status:");

        $order = $stubGenPay->order();
        $customer = $stubGenPay->customer();
        $payment = $stubGenPay->asBillet();

        $stubGenPay->createOrder($order, $customer, $payment);
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

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $stubGenPay->checkout(1000);
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

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $this->expectExceptionMessage("Unknown Error in Responsibility:  - Status:");

        $stubGenPay->checkout(1000);
    }

    public function testItShouldGetAuthorizationAndReturnSuccess()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Authorization is OK");

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('get');
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $response = $stubGenPay->authorizationValidate();

        $this->assertEquals(Status::OK, $response->getResponse()->getStatus());
    }

    public function testItShouldGetAuthorizationAndReturnException()
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

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $this->expectExceptionMessage("Unknown Error in Responsibility:  - Status:");

        $stubGenPay->authorizationValidate();
    }

    public function testItShouldCancelOrder()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getResultRefundSuccess());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post')
            ->willReturn($this->getResultRefundSuccess());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $response = $stubGenPay->cancel("fake-charge-uuid", Requester::MERCHANT, "Comprou errado.");

        $this->assertInstanceOf(\GenComm\Parser\GenPay\Transaction\Refund::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertCount(1, $response->getRefunds(), "Refunds array");
        $this->assertCount(4, $response->getStatusHistory(), "Status History");
        $this->assertEquals('refunded', $response->getStatus(), "Status Code");
        $this->assertEmpty($response->getMessage(), "Message");
    }

    public function testItShouldRefundOrder()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getResultRefundSuccess());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post')
            ->willReturn($this->getResultRefundSuccess());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $refund = $stubGenPay->asRefund();
        $bank  =[
            'document' => '11111111111',
            'bank_code' => '341',
            'bank_agency' => '1234',
            'bank_number' => '12345678-1',

        ];
        $refund->setReason("Errado")
            ->setRequester("merchant")
            ->addPayment('fake-payment-id', 200, $bank);

        $response = $stubGenPay->refund($refund, "fake-charge-uuid");

        $this->assertInstanceOf(\GenComm\Parser\GenPay\Transaction\Refund::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertCount(1, $response->getRefunds(), "Refunds array");
        $this->assertCount(4, $response->getStatusHistory(), "Status History");
        $this->assertEquals('refunded', $response->getStatus(), "Status Code");
        $this->assertEmpty($response->getMessage(), "Message");
    }

    public function testItShouldRefundPartialOrder()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getResultRefundSuccess());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post')
            ->willReturn($this->getResultRefundSuccess());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubGenPay = $this->getMockBuilder(GenPay::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubGenPay->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $refund = $stubGenPay->asRefund();
        $bank  =[
            'document' => '11111111111',
            'bank_code' => '341',
            'bank_agency' => '1234',
            'bank_number' => '12345678-1',

        ];
        $refund->setReason("Errado")
            ->setRequester("merchant")
            ->addPayment('fake-payment-id', 50, $bank);

        $response = $stubGenPay->refund($refund, "fake-charge-uuid");

        $this->assertInstanceOf(\GenComm\Parser\GenPay\Transaction\Refund::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertCount(1, $response->getRefunds(), "Refunds array");
        $this->assertCount(4, $response->getStatusHistory(), "Status History");
        $this->assertEquals('refunded', $response->getStatus(), "Status Code");
        $this->assertEmpty($response->getMessage(), "Message");
    }

    /**
     * @return string
     */
    public function getResultCreateOrder()
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

    /**
     * @return string
     */
    protected function getResultRefundSuccess()
    {
        $jsonSuccess = '
        {
          "uuid": "fake-charge-uuid",
          "subscription": {},
          "status_history": [
            {
              "status": "refunded",
              "created_at": "2019-07-01T17:30:35-03:00"
            },
            {
              "status": "approved",
              "created_at": "2019-07-01T17:23:44-03:00"
            },
            {
              "status": "authorized",
              "created_at": "2019-07-01T17:15:49-03:00"
            },
            {
              "status": "pending",
              "created_at": "2019-07-01T17:15:49-03:00"
            }
          ],
          "status": "refunded",
          "shipping": {
            "time": null,
            "kind": null,
            "company": null,
            "amount": 0.0,
            "adjustments": []
          },
          "refunds": [
            {
              "status": "refunded",
              "requester": "merchant",
              "reason": "Errado",
              "payments": [
                {
                  "status": "refunded",
                  "id": "fake-payment-id",
                  "amount": 200.0
                }
              ],
              "id": "7766703d-d33c-4fbd-871b-01a93b1511ef",
              "created_at": "2019-07-01T17:30:35-03:00",
              "amount": "200.0"
            }
          ],
          "reference": "SDK03",
          "payments": [
            {
              "status_history": [
                {
                  "status": "cancelled",
                  "created_at": "2019-07-01T17:30:35-03:00"
                },
                {
                  "status": "approved",
                  "created_at": "2019-07-01T17:23:44-03:00"
                },
                {
                  "status": "authorized",
                  "created_at": "2019-07-01T17:15:49-03:00"
                },
                {
                  "status": "pending",
                  "created_at": "2019-07-01T17:15:49-03:00"
                }
              ],
              "status": "cancelled",
              "refundable_amount": 0.0,
              "reference": "",
              "method": "billet",
              "id": "fake-payment-id",
              "billet": {
                "url": "https://api-sandbox.rakutenpay.com.br/v1/billets/fake-payment-id",
                "number": "4221001",
                "download_url": "https://api-sandbox.rakutenpay.com.br/v1/charges/fake-charge-uuid/billet/download"
              },
              "amount": 200.0
            }
          ],
          "order": {
            "total_amount": 200.0,
            "shipping_time": null,
            "shipping_kind": null,
            "shipping_company": null,
            "shipping_amount": 0.0,
            "reference": "SDK03",
            "items_amount": 200.0,
            "discount_amount": 0.0
          },
          "merchant": {
            "seller_id": "fake-seller-id",
            "merchant_id": "fake-merchant-id",
            "document": "fake-document"
          },
          "created_at": "2019-07-01T17:15:49-03:00",
          "commissionings": [],
          "amount": "200.0"
        }';

        return $jsonSuccess;
    }
}