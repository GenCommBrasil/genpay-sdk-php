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

namespace GenComm\Tests\Unit\Service\Http;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Status;
use GenComm\Exception\GenCommException;
use GenComm\Parser\Error;
use GenComm\Service\Http\Responsibility;
use GenComm\Service\Http\Webservice;
use GenComm\Parser\GenPay\Factory;
use GenComm\Service\Http\Response\Response;

class ResponsibilityTest extends TestCase
{
    /**
     * @dataProvider additionProviderReturnInstanceOf
     */
    public function testShouldReturnInstanceOf($status, $data, $expected)
    {
        $response = new Response();
        $response->setStatus($status);
        $response->setResult($data);

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $creditCard = Factory::create('GenComm\Resource\GenPay\CreditCard');
        $response = Responsibility::http($stubWebservice, $creditCard);

        $this->assertInstanceOf($expected, $response);
    }

    /**
     * @dataProvider additionProviderException
     */
    public function testShouldReturnException($status, $data, $expected)
    {
        $response = new Response();
        $response->setStatus($status);
        $response->setResult($data);

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $creditCard = Factory::create('GenComm\Resource\GenPay\CreditCard');
        $this->expectException(GenCommException::class);
        Responsibility::http($stubWebservice, $creditCard);
    }

    public function additionProviderReturnInstanceOf()
    {
        return [
            [Status::OK, $this->getDataSuccess(), \GenComm\Parser\GenPay\Transaction\CreditCard::class],
            [Status::UNPROCESSABLE, $this->getDataError(), Error::class],
            [Status::BAD_REQUEST, $this->getDataError(), Error::class],
        ];
    }

    public function additionProviderException()
    {
        return [
            [Status::NOT_FOUND, $this->getDataError(), Error::class],
            [Status::UNAUTHORIZED, $this->getDataError(), Error::class],
            [Status::BAD_GATEWAY, $this->getDataError(), Error::class],
            [000, $this->getDataError(), Error::class],
        ];
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
