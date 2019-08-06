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
use Rakuten\Connector\Parser\RakutenLog\Transaction\OrderDetail;
use Rakuten\Connector\Service\Http\Response\Response;

class OrderDetailTest extends TestCase
{
    /**
     * @var OrderDetail
     */
    private $orderDetail;

    public function setUp()
    {
        $this->orderDetail = new OrderDetail();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Calculation Transaction Response");

        $status = "OK";
        $code = "fake-code";
        $calculationCode = "fake-calculation-code";
        $batchCode = "fake-batch-code";
        $carrierType = "fake-carrier-type";
        $trackingUrl = "fake-tracking-url";
        $printUrl = "fake-print-url";
        $customer = [
            "last_name" => "Da Silva",
            "first_name" => "Teste",
            "display_name" => "Teste Da Silva",
            "cpf" => "12345678909",
        ];
        $deliveryAddress = [
              "zipcode" => "21920070",
              "street" => "Rua Capanema",
              "state" => "SP",
              "reference" => "",
              "phone" => "1144556677",
              "number" => "500",
              "mobile" => "",
              "fax" => "1155667788",
              "email" => "teste@teste.com.br",
              "district" => "Rua dos Piao",
              "contact_name" => "Teste TEste da Silva",
              "complement" => "Torre New York 6 Andar",
              "city" => "Rio de Janeiro",
        ];

        $this->orderDetail->setStatus($status);
        $this->orderDetail->setCode($code);
        $this->orderDetail->setCalculationCode($calculationCode);
        $this->orderDetail->setBatchCode($batchCode);
        $this->orderDetail->setCarrierType($carrierType);
        $this->orderDetail->setTrackingUrl($trackingUrl);
        $this->orderDetail->setPrintUrl($printUrl);
        $this->orderDetail->setCustomer($customer);
        $this->orderDetail->setDeliveryAddress($deliveryAddress);
        $this->orderDetail->setResponse($response);
        $this->orderDetail->setMessage('');

        $this->assertInstanceOf(OrderDetail::class, $this->orderDetail);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($status, $this->orderDetail->getStatus(), "OrderDetail Status");
        $this->assertEquals($code, $this->orderDetail->getCode(), "OrderDetail Codel");
        $this->assertEquals($calculationCode, $this->orderDetail->getCalculationCode(), "OrderDetail Calculation Code");
        $this->assertEquals($batchCode, $this->orderDetail->getBatchCode(), "OrderDetail Batch Code");
        $this->assertEquals($carrierType, $this->orderDetail->getCarrierType(), "OrderDetail Carrier Type");
        $this->assertEquals($trackingUrl, $this->orderDetail->getTrackingUrl(), "OrderDetail Tracking URL");
        $this->assertEquals($printUrl, $this->orderDetail->getPrintUrl(), "OrderDetail Print URL");
        $this->assertEquals(Status::OK, $this->orderDetail->getResponse()->getStatus());
        $this->assertCount(4, $this->orderDetail->getCustomer(), "OrderDetail Customer");
        $this->assertCount(13, $this->orderDetail->getDeliveryAddress(), "OrderDetail Delivery Address");
        $this->assertEmpty($this->orderDetail->getMessage());
    }
}
