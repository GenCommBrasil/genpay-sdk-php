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

namespace GenComm\Tests\Unit\Parser\GenPay;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Status;
use GenComm\Parser\Error;
use GenComm\Parser\GenPay\Checkout;
use GenComm\Service\Http\Webservice;
use GenComm\Service\Http\Response\Response;

class CheckoutTest extends TestCase
{
    public function testShouldSucceedAndReturnTransactionCheckout()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getData());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();

        $stubWebservice->expects($this->exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $response = Checkout::success($stubWebservice);

        $this->assertInstanceOf(\GenComm\Parser\GenPay\Transaction\Checkout::class, $response);
        $this->assertFalse($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertCount(12, $response->getInstallments());
        $this->assertEquals("success", $response->getResult());
        $this->assertEmpty($response->getMessage());
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $response = new Response();
        $response->setStatus(Status::BAD_REQUEST);
        $response->setResult($this->getDataError());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();

        $stubWebservice->expects($this->exactly(3))
            ->method('getResponse')
            ->willReturn($response);

        $response = Checkout::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertTrue($response->isError());
        $this->assertEquals(Status::BAD_REQUEST, $response->getCode(), "Code Status");
        $this->assertEquals("Amount is missing - Amount must be greater than 0", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getData()
    {
        $jsonSuccess = '
        {
          "result": "success",
          "payments": [
            {
              "method": "balance",
              "currency": "BRL",
              "amount": 30686.28
            },
            {
              "method": "credit_card",
              "installments": [
                {
                  "total": 109.17,
                  "quantity": 1,
                  "interest_percent": 2.99,
                  "interest_amount": 3.17,
                  "installment_amount": 109.17
                },
                {
                  "total": 110.8,
                  "quantity": 2,
                  "interest_percent": 4.53,
                  "interest_amount": 4.8,
                  "installment_amount": 55.4
                },
                {
                  "total": 112.47,
                  "quantity": 3,
                  "interest_percent": 6.09,
                  "interest_amount": 6.47,
                  "installment_amount": 37.49
                },
                {
                  "total": 114.16,
                  "quantity": 4,
                  "interest_percent": 7.7,
                  "interest_amount": 8.16,
                  "installment_amount": 28.54
                },
                {
                  "total": 115.9,
                  "quantity": 5,
                  "interest_percent": 9.33,
                  "interest_amount": 9.9,
                  "installment_amount": 23.18
                },
                {
                  "total": 117.6,
                  "quantity": 6,
                  "interest_percent": 10.96,
                  "interest_amount": 11.6,
                  "installment_amount": 19.6
                },
                {
                  "total": 119.42,
                  "quantity": 7,
                  "interest_percent": 12.63,
                  "interest_amount": 13.42,
                  "installment_amount": 17.06
                },
                {
                  "total": 121.28,
                  "quantity": 8,
                  "interest_percent": 14.44,
                  "interest_amount": 15.28,
                  "installment_amount": 15.16
                },
                {
                  "total": 123.12,
                  "quantity": 9,
                  "interest_percent": 16.19,
                  "interest_amount": 17.12,
                  "installment_amount": 13.68
                },
                {
                  "total": 125.1,
                  "quantity": 10,
                  "interest_percent": 18.01,
                  "interest_amount": 19.1,
                  "installment_amount": 12.51
                },
                {
                  "total": 126.83,
                  "quantity": 11,
                  "interest_percent": 19.66,
                  "interest_amount": 20.83,
                  "installment_amount": 11.53
                },
                {
                  "total": 129.0,
                  "quantity": 12,
                  "interest_percent": 21.65,
                  "interest_amount": 23.0,
                  "installment_amount": 10.75
                }
              ],
              "cards": [],
              "brands": [
                "visa",
                "mastercard",
                "diners",
                "hipercard",
                "amex",
                "elo",
                "jcb"
              ],
              "amount": 106.0
            },
            {
              "method": "billet",
              "amount": 106.0
            }
          ]
        }';

        return $jsonSuccess;
    }

    /**
     * @return string
     */
    protected function getDataError()
    {
        return '
        {
            "result_messages": [
            "Amount is missing",
            "Amount must be greater than 0"
            ],
            "result": "failure"
        }';
    }
}
