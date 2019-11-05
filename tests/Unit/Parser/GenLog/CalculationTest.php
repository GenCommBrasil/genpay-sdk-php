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

namespace GenComm\Tests\Unit\Parser\GenLog;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Status;
use GenComm\Parser\Error;
use GenComm\Parser\GenLog\Calculation;
use GenComm\Service\Http\Response\Response;
use GenComm\Service\Http\Webservice;

class CalculationTest extends TestCase
{
    public function testShouldSucceedAndReturnTransactionCalculation()
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

        $response = Calculation::success($stubWebservice);

        $this->assertInstanceOf(\GenComm\Parser\GenLog\Transaction\Calculation::class, $response);
        $this->assertFalse($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('OK', $response->getStatus(), "Calculation Status");
        $this->assertEquals('fake-code', $response->getCode(), "Calculation Code");
        $this->assertEquals('fake-owner-code', $response->getOwnerCode(), "Calculation Onwer Code");
        $this->assertEquals('2019-07-31T11:19:16', $response->getExpirationDate(), "Calculation Expiration Date");
        $this->assertCount(1, $response->getShippingOptions(), "Calculation Shipping Options");
        $this->assertEmpty($response->getMessage(), "Calculation Message");
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

        $stubWebservice->expects($this->exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $response = Calculation::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertTrue($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('ERROR', $response->getCode(), "Code Error");
        $this->assertEquals("CEP de destino não informado!", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
    {
        $jsonSuccess = '
        {
          "status": "OK",
          "messages": [],
          "content": {
            "shipping_options": [
              {
                "with_rakuten_contract": true,
                "volumes": [
                  {
                    "products": [
                      {
                        "size": 0,
                        "quantity": 1,
                        "name": "TENIS NIKE",
                        "dimensions": {
                          "width": 1.0,
                          "weight": 1.0,
                          "length": 1.0,
                          "height": 1.0
                        },
                        "cost": 50.0,
                        "code": "1"
                      }
                    ],
                    "number_of_volumes": 1,
                    "number": 1,
                    "final_cost": 11.15,
                    "dimensions": {
                      "width": 11.0,
                      "weight": 1.0,
                      "length": 16.0,
                      "height": 2.0
                    },
                    "delivery_time": 1,
                    "cost": 11.15,
                    "base_time": 1,
                    "additional_warehouse_time": 0,
                    "additional_time": 0,
                    "additional_cost": 0.0,
                    "additional_carrier_time": 0
                  }
                ],
                "postage_service_name": "SEDEX CONTRATO AGENCIA",
                "postage_service_display_name": "SEDEX CONTRATO AGENCIA",
                "postage_service_code": "5a4ddd71-b701-4d1c-a1d0-f06b32ef7044",
                "logistics_operator_type_id": 1,
                "logistics_operator_type": "Correios",
                "logistics_operator_message": "",
                "logistics_operator_code": "04162",
                "is_fault_back": false,
                "final_cost": 11.15,
                "elapsed_time": 6194,
                "delivery_time": 1,
                "cost": 11.15,
                "base_time": 1,
                "additional_time": 0,
                "additional_cost": 0.0
              }
            ],
            "owner_code": "fake-owner-code",
            "origin_zipcode": "01415000",
            "expiration_date": "2019-07-31T11:19:16",
            "destination_zipcode": "09840530",
            "code": "fake-code"
          }
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
          "status": "ERROR",
          "messages": [
            {
              "type": "ERROR",
              "text": "CEP de destino não informado!"
            }
          ]
        }                
        ';

        return $jsonError;
    }
}
