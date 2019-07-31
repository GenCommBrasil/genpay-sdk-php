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
use Rakuten\Connector\Parser\RakutenLog\Transaction\Calculation;
use Rakuten\Connector\RakutenLog;
use Rakuten\Connector\Service\Http\Response\Response;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\RakutenLog\Transaction\Autocomplete;

class RakutenLogTest extends TestCase
{
    public function testItShouldCreateCalculationAndReturnSuccess()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getCalculationSuccess());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post')
            ->willReturn($this->getCalculationSuccess());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubRakutenLog = $this->getMockBuilder(RakutenLog::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenLog->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $calculation = $stubRakutenLog->calculation();

        $response = $stubRakutenLog->createCalculation($calculation);

        $this->assertInstanceOf(Calculation::class, $response);
        $this->assertFalse($response->isError());
    }

    public function testItShouldCreateCalculationAndReturnException()
    {
        $response = new Response();
        $response->setStatus('');
        $response->setResult('');

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['post', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('post')
            ->willReturn($this->getCalculationSuccess());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubRakutenLog = $this->getMockBuilder(RakutenLog::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenLog->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $calculation = $stubRakutenLog->calculation();

        $this->expectExceptionMessage("Unknown Error in Responsibility:  - Status:");

        $stubRakutenLog->createCalculation($calculation);
    }

    public function testItShouldAutocompleteAndReturnSuccess()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getAutocompleteSuccess());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('get')
            ->willReturn($this->getAutocompleteSuccess());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubRakutenLog = $this->getMockBuilder(RakutenLog::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenLog->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $response = $stubRakutenLog->autocomplete("01415001", true);

        $this->assertInstanceOf(Autocomplete::class, $response);
        $this->assertFalse($response->isError());
    }

    public function testItShouldAutocompleteAndReturnException()
    {
        $response = new Response();
        $response->setStatus('');
        $response->setResult('');

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'getResponse'])
            ->getMock();
        $stubWebservice->expects($this->once())
            ->method('get')
            ->willReturn($this->getAutocompleteSuccess());
        $stubWebservice->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        $stubRakutenLog = $this->getMockBuilder(RakutenLog::class)
            ->setConstructorArgs(["fake-document", "fake-apikey", "fake-signature", Environment::SANDBOX])
            ->setMethods(['getWebservice'])
            ->getMock();
        $stubRakutenLog->expects($this->once())
            ->method('getWebservice')
            ->willReturn($stubWebservice);

        $this->expectExceptionMessage("Unknown Error in Responsibility:  - Status:");

        $response = $stubRakutenLog->autocomplete("01415001", true);
    }

    /**
     * @return string
     */
    protected function getCalculationSuccess()
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
    protected function getCalculationError()
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

    protected function getAutocompleteSuccess()
    {
        return '
        {
          "status": "OK",
          "messages": [],
          "content": {
            "street": "Rua Bela Cintra",
            "district": "Consolação",
            "city": "São Paulo",
            "state": "SP",
            "zipcode": "01415001"
          }
        }';
    }
}