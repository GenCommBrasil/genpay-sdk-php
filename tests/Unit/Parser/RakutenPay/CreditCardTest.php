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

namespace Rakuten\Tests\Unit\Parser\RakutenPay;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Parser\RakutenPay\CreditCard;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Service\Http\Response\Response;

class CreditCardTest extends TestCase
{
    public function testShouldSucceedAndReturnTransactionCreditCard()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getDataSuccess());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();

        $stubWebservice->expects($this->exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $response = CreditCard::success($stubWebservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenPay\Transaction\CreditCard::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertFalse($response->isError());
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertEquals('SDG-DSG-DS-G-DS', $response->getPaymentId(), "Payment ID");
        $this->assertEquals('411111******1111', $response->getCreditCardNum(), "Credit Card Number");
        $this->assertEquals('authorized', $response->getStatus(), "Status Code");
        $this->assertEmpty($response->getMessage(), "Message");
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $response = new Response();
        $response->setStatus(Status::UNPROCESSABLE);
        $response->setResult($this->getDataError());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();

        $stubWebservice->expects($this->exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $response = CreditCard::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertTrue($response->isError());
        $this->assertEquals(999, $response->getCode(), "Code Status");
        $this->assertEquals("Installments amount doesnt match. Payment credit_card in 3 times of 70.90 should be 212.70", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
    {
        $jsonSuccess = '
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
          "reference": "160",
          "payments": [
            {
              "status": "authorized",
              "result_messages": [],
              "result": "success",
              "refundable_amount": 100.0,
              "reference": "1",
              "method": "credit_card",
              "id": "SDG-DSG-DS-G-DS",
              "credit_card": {
                "tid": "11111111111111",
                "processor": "cielo",
                "number": "411111******1111",
                "nsu": "492734",
                "authorization_message": "Transaction Approved",
                "authorization_code": "123456"
              },
              "amount": 100.0
            }
          ],
          "fingerprint": "fake-fingerprint",
          "commissionings": [],
          "charge_uuid": "fake-charge-uuid"
        }';

        return $jsonSuccess;
    }

    /**
     * @return string
     */
    protected function getDataError()
    {
        $jsonError = '
        {
          "result_messages": [
            "Installments amount doesnt match. Payment credit_card in 3 times of 70.90 should be 212.70"
          ],
          "result_code": {
            "message": [
              "Installments amount doesnt match. Payment credit_card in 3 times of 70.90 should be 212.70"
            ],
            "code": 999
          },
          "result": "failure",
          "reference": "",
          "payments": [],
          "charge_uuid": ""
        }                
        ';

        return $jsonError;
    }
}
