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

namespace Rakuten\Tests\Unit\Parser\RakutenLog\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\RakutenLog\Transaction\Calculation;
use Rakuten\Connector\Service\Http\Response\Response;

class CalculationTest extends TestCase
{
    /**
     * @var Calculation
     */
    private $calculation;

    public function setUp()
    {
        $this->calculation = new Calculation();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Calculation Transaction Response");

        $code = "fake-code";
        $ownerCode = "fake-owner-code";
        $shippingOptions = json_decode($this->getShippingOptions(), true);
        $expirationDate = "2019-07-31T11:19:16";

        $this->calculation->setCode($code);
        $this->calculation->setOwnerCode($ownerCode);
        $this->calculation->setExpirationDate($expirationDate);
        $this->calculation->setShippingOptions($shippingOptions);
        $this->calculation->setResponse($response);
        $this->calculation->setMessage('');

        $this->assertInstanceOf(Calculation::class, $this->calculation);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($code, $this->calculation->getCode(), "Calculation Code Result");
        $this->assertEquals($ownerCode, $this->calculation->getOwnerCode(), "Calculation Owner Code");
        $this->assertEquals(Status::OK, $this->calculation->getResponse()->getStatus());
        $this->assertCount(2, $this->calculation->getShippingOptions(), "Calculation Shipping Options");
        $this->assertEquals($expirationDate, $this->calculation->getExpirationDate(), "Calculation Expiration Date");
        $this->assertEmpty($this->calculation->getMessage());
    }

    private function getShippingOptions()
    {
        return '[
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
          },
          {
            "with_rakuten_contract": false,
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
                "final_cost": 16.42,
                "dimensions": {
                  "width": 1.0,
                  "weight": 1.0,
                  "length": 1.0,
                  "height": 1.0
                },
                "delivery_time": 5,
                "cost": 16.42,
                "base_time": 5,
                "additional_warehouse_time": 0,
                "additional_time": 0,
                "additional_cost": 0.0,
                "additional_carrier_time": 0
              }
            ],
            "postage_service_name": "Correios PAC",
            "postage_service_display_name": "das",
            "postage_service_code": "63d704e8-dc82-4f7d-8ae2-6b56fb3ded82",
            "logistics_operator_type_id": 2,
            "logistics_operator_type": "Intelipost",
            "logistics_operator_message": "",
            "logistics_operator_code": "1",
            "is_fault_back": false,
            "final_cost": 16.42,
            "elapsed_time": 205,
            "delivery_time": 5,
            "cost": 16.42,
            "base_time": 5,
            "additional_time": 0,
            "additional_cost": 0.0
          }
        ]';
    }
}
