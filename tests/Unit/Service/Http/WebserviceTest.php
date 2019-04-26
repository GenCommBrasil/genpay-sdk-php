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

namespace Rakuten\Tests\Unit\Service\Http;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Enum\Endpoint;

class WebserviceTest extends TestCase
{
    public function testMethodPostForCreateChargeURLWithReturnSuccess()
    {
        $info = ['http_code' => Status::OK];

        $rakutenPay = new RakutenPay("fake-document", "fake-apikey", "fake-signature", "sandbox");
        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->setConstructorArgs([$rakutenPay])
            ->setMethods(['setOption', 'execute', 'getInfo', 'getErrorCode', 'getErrorMessage', 'close'])
            ->getMock();

        $stubWebservice->expects($this->once())
            ->method('setOption');
        $stubWebservice->expects($this->once())
            ->method('close');

        $stubWebservice->expects($this->once())
            ->method('execute')
            ->willReturn($this->getResponseSuccess());
        $stubWebservice->expects($this->once())
            ->method('getInfo')
            ->willReturn($info);

        $stubWebservice->expects($this->once())
            ->method('getErrorCode')
            ->willReturn(0);

        $stubWebservice->expects($this->once())
            ->method('getErrorMessage')
            ->willReturn('');

        $stubWebservice->post(
            Endpoint::createChargeUrl($rakutenPay->getEnvironment()),
            $this->getPayload());
    }

    public function testMethodGetWithReturnSuccessInCheckout()
    {
        $info = ['http_code' => Status::OK];

        $rakutenPay = new RakutenPay("fake-document", "fake-apikey", "fake-signature", "sandbox");
        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->setConstructorArgs([$rakutenPay])
            ->setMethods(['setOption', 'execute', 'getInfo', 'getErrorCode', 'getErrorMessage', 'close'])
            ->getMock();

        $stubWebservice->expects($this->once())
            ->method('setOption');
        $stubWebservice->expects($this->once())
            ->method('close');

        $stubWebservice->expects($this->once())
            ->method('execute')
            ->willReturn($this->getResponseSuccess());
        $stubWebservice->expects($this->once())
            ->method('getInfo')
            ->willReturn($info);

        $stubWebservice->expects($this->once())
            ->method('getErrorCode')
            ->willReturn(0);

        $stubWebservice->expects($this->once())
            ->method('getErrorMessage')
            ->willReturn('');

        $url = sprintf(
            "%s?%s",
            Endpoint::buildCheckoutUrl($rakutenPay->getEnvironment()),
            sprintf("%s=%s", "amount", 10000)
        );
        $stubWebservice->get($url);

    }

    public function testMethodPostWithWithDataIsEmptyReturnException()
    {
        $rakutenPay = new RakutenPay("fake-document", "fake-apikey", "fake-signature", "sandbox");
        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->setConstructorArgs([$rakutenPay])
            ->setMethods(['setOption', 'execute', 'getInfo', 'getErrorCode', 'getErrorMessage', 'close'])
            ->getMock();

        $stubWebservice->expects($this->never())
            ->method('setOption');
        $stubWebservice->expects($this->never())
            ->method('close');

        $stubWebservice->expects($this->never())
            ->method('execute');
        $stubWebservice->expects($this->never())
            ->method('getInfo');

        $stubWebservice->expects($this->never())
            ->method('getErrorCode');

        $stubWebservice->expects($this->never())
            ->method('getErrorMessage');

        $this->expectException(RakutenException::class);
        $this->expectExceptionMessage("Payload is empty.");

        $stubWebservice->post(
            Endpoint::createChargeUrl($rakutenPay->getEnvironment()),
            '');
    }

    public function testMethodPostWithErrorInCurlReturnException()
    {
        $info = ['http_code' => Status::OK];
        $errorCode = Status::INTERNAL_SERVER_ERROR;

        $rakutenPay = new RakutenPay("fake-document", "fake-apikey", "fake-signature", "sandbox");
        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->setConstructorArgs([$rakutenPay])
            ->setMethods(['setOption', 'execute', 'getInfo', 'getErrorCode', 'getErrorMessage', 'close'])
            ->getMock();

        $stubWebservice->expects($this->once())
            ->method('setOption');
        $stubWebservice->expects($this->once())
            ->method('close');

        $stubWebservice->expects($this->once())
            ->method('execute')
            ->willReturn($this->getResponseSuccess());
        $stubWebservice->expects($this->once())
            ->method('getInfo')
            ->willReturn($info);

        $stubWebservice->expects($this->once())
            ->method('getErrorCode')
            ->willReturn($errorCode);

        $stubWebservice->expects($this->once())
            ->method('getErrorMessage')
            ->willReturn('Server not Found');

        $this->expectException(RakutenException::class);
        $this->expectExceptionMessage("CURL can't connect: Server not Found");

        $stubWebservice->post(
            Endpoint::createChargeUrl($rakutenPay->getEnvironment()),
            $this->getPayload());
    }

    /**
     * @return string
     */
    protected function getResponseSuccess()
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
    protected function getPayload()
    {
        $json = '
        {
          "webhook_url": "http://localhost/teste/teste/sdk/",
          "reference": "SDK-1",
          "payments": [
            {
              "method": "billet",
              "expires_on": "3",
              "amount": 200.0
            }
          ],
          "order": {
            "taxes_amount": 0.0,
            "shipping_amount": 0.0,
            "reference": "SDK-1",
            "payer_ip": "127.0.0.1",
            "items_amount": 200.0,
            "items": [
              {
                "total_amount": 200.0,
                "reference": "SDK-10",
                "quantity": 1,
                "description": "NIKE TENIS",
                "categories": [
                  {
                    "name": "Outros",
                    "id": "99"
                  }
                ],
                "amount": 200.0
              }
            ],
            "discount_amount": 0.0
          },
          "fingerprint": "c9a3374e5b564eca2e734a81c01f0a54-fodm1ud7nrejul9x1d7",
          "customer": {
            "phones": [
              {
                "reference": "others",
                "number": {
                  "number": "999999998",
                  "country_code": "55",
                  "area_code": "11"
                },
                "kind": "shipping"
              },
              {
                "reference": "others",
                "number": {
                  "number": "999999998",
                  "country_code": "55",
                  "area_code": "11"
                },
                "kind": "billing"
              }
            ],
            "name": "Alex",
            "kind": "personal",
            "email": "teste@teste.com.br",
            "document": "12345678909",
            "business_name": "DR. Alex",
            "birth_date": "1985-04-16",
            "addresses": [
              {
                "zipcode": "09840-500",
                "street": "Rua Dos Morros",
                "state": "SP",
                "number": "1000",
                "kind": "shipping",
                "district": "ABC",
                "country": "BRA",
                "contact": "Maria",
                "complement": "",
                "city": "Maua"
              },
              {
                "zipcode": "09840-500",
                "street": "Rua Dos Morros",
                "state": "SP",
                "number": "1000",
                "kind": "billing",
                "district": "ABC",
                "country": "BRA",
                "contact": "Maria",
                "complement": "",
                "city": "Maua"
              }
            ]
          },
          "currency": "BRL",
          "amount": 200.0
        }';

        return $json;
    }
}
