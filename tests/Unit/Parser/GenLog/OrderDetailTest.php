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
use GenComm\Parser\GenLog\OrderDetail;
use GenComm\Service\Http\Response\Response;
use GenComm\Service\Http\Webservice;

class OrderDetailTest extends TestCase
{
    public function testShouldSucceedAndReturnTransactionOrderDetail()
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

        $response = OrderDetail::success($stubWebservice);

        $this->assertInstanceOf(\GenComm\Parser\GenLog\Transaction\OrderDetail::class, $response);
        $this->assertFalse($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('OK', $response->getStatus(), "OrderDetail Status");
        $this->assertEquals('fake-code', $response->getCode(), "OrderDetail Code");
        $this->assertEquals('fake-calculation-code', $response->getCalculationCode(), "OrderDetail Calculation Code");
        $this->assertEquals('fake-batch-code', $response->getBatchCode(), "OrderDetail Batch Code");
        $this->assertEquals('fake-tracking-url', $response->getTrackingUrl(), "OrderDetail Tracking URL");
        $this->assertEquals('fake-print-url', $response->getPrintUrl(), "OrderDetail Expiration Date");
        $this->assertEquals('Cargo BR', $response->getCarrierType(), "OrderDetail Carrier Type");
        $this->assertCount(13, $response->getDeliveryAddress(), "OrderDetail Delivery Address");
        $this->assertCount(4, $response->getCustomer(), "OrderDetail Customer");
        $this->assertEmpty($response->getMessage(), "OrderDetail Message");
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

        $response = OrderDetail::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertTrue($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('ERROR', $response->getCode(), "Code Error");
        $this->assertEquals("Postagem 1666000000 não foi encontrada.", $response->getMessage(), "Error Message");
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
            "update_date": "2019-08-02T10:33:51",
            "trackings_number": [
              "1666000041"
            ],
            "tracking_value_calculated": 200.83,
            "tracking_value_billed": 0.0,
            "tracking_print_url": "fake-tracking-url",
            "total_value": 200.83,
            "store_type": "Padrão",
            "store_code": "fake-store-code",
            "status_display_name": "Criado",
            "status": "Criado",
            "shipping_option": {
              "with_rakuten_contract": false,
              "volumes": [
                {
                  "tracking_number": "1666000041",
                  "products": [
                    {
                      "size": 0,
                      "quantity": 1,
                      "dimensions": {
                        "width": 0.0,
                        "weight": 1.0,
                        "length": 0.0,
                        "height": 0.0
                      },
                      "code": "wbk004"
                    },
                    {
                      "size": 0,
                      "quantity": 1,
                      "dimensions": {
                        "width": 0.0,
                        "weight": 1.0,
                        "length": 0.0,
                        "height": 0.0
                      },
                      "code": "wbk004"
                    }
                  ],
                  "number_of_volumes": 1,
                  "number": 1,
                  "final_cost": 200.83,
                  "dimensions": {
                    "width": 0.0,
                    "weight": 2.0,
                    "length": 0.0,
                    "height": 0.0
                  },
                  "delivery_time": 2,
                  "cost": 200.83,
                  "commission_cost": 0.0,
                  "base_time": 0,
                  "additional_warehouse_time": 0,
                  "additional_time": 0,
                  "additional_cost": 0.0,
                  "additional_carrier_time": 0
                }
              ],
              "postage_service_name": "Transporte Generoso",
              "postage_service_display_name": "Transporte Generoso",
              "postage_service_code": "1260e7a5-edb1-4854-a4f7-60de24cb37dd",
              "logistics_operator_type_id": 5,
              "logistics_operator_type": "CargoBR",
              "logistics_operator_message": "",
              "logistics_operator_code": "2124",
              "is_fault_back": false,
              "final_cost": 200.83,
              "elapsed_time": 1413,
              "delivery_time": 2,
              "cost": 200.83,
              "commission_cost": 0.0,
              "base_time": 0,
              "additional_time": 0,
              "additional_cost": 0.0
            },
            "postage_service": "Transporte Generoso",
            "payments_charge_id": "",
            "order_date": "2019-08-02T10:33:51",
            "invoice": {},
            "internal_code": "1666000041",
            "delivery_address": {
              "zipcode": "21920070",
              "street": "Rua Capanema",
              "state": "SP",
              "reference": "",
              "phone": "1144556677",
              "number": "500",
              "mobile": "",
              "fax": "1155667788",
              "email": "teste@teste.com.br",
              "district": "Rua dos Piao",
              "contact_name": "Teste TEste da Silva",
              "complement": "Torre New York 6 Andar",
              "city": "Rio de Janeiro"
            },
            "customer_order_number": "1666000040",
            "customer": {
              "last_name": "Da Silva",
              "first_name": "Teste",
              "display_name": "Teste Da Silva",
              "cpf": "12345678909"
            },
            "code": "fake-code",
            "charge_external_payments": false,
            "carrier_type": "Cargo BR",
            "can_remove_from_batch": false,
            "calculation_code": "fake-calculation-code",
            "batch_print_url": "fake-print-url",
            "batch_code": "fake-batch-code"
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
              "text": "Postagem 1666000000 não foi encontrada."
            }
          ]
        }                            
        ';

        return $jsonError;
    }
}
