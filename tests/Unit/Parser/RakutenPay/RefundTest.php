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

namespace Rakuten\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\Parser\RakutenPay\Refund;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Service\Http\Response\Response;

class RefundTest extends TestCase
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

        $response = Refund::success($stubWebservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenPay\Transaction\Refund::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertFalse($response->isError());
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertCount(1, $response->getRefunds(), "Refunds array");
        $this->assertCount(4, $response->getStatusHistory(), "Status History");
        $this->assertEquals('refunded', $response->getStatus(), "Status Code");
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

        $response = Refund::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertTrue($response->isError());
        $this->assertEquals(1000, $response->getCode(), "Code Status");
        $this->assertEquals("Charge not found", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
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
              "requester": "rakuten",
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

    /**
     * @return string
     */
    protected function getDataError()
    {
        $jsonError = '
        {
          "result_messages": [
            "Charge not found"
          ],
          "result_code": {
            "message_error": "Charge not found",
            "id": "charge_not_found",
            "code": 1000
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
