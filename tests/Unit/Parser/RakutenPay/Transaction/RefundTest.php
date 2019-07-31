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

namespace Rakuten\Tests\Unit\Parser\RakutenPay\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Refund;
use Rakuten\Connector\Service\Http\Response\Response;
use Rakuten\Connector\Enum\Status;

class RefundTest extends TestCase
{
    /**
     * @var Refund
     */
    private $refund;

    public function setUp()
    {
        $this->refund = new Refund();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Transaction OK");

        $chargeId = "fake-charge-uuid";
        $status = "refunded";
        $statusHistory = [
            [
                "status" => "cancelled",
                "created_at" => "2019-07-01T17:30:35-03:00"
            ],
            [
                "status" => "approved",
                "created_at" => "2019-07-01T17:23:44-03:00"
            ],
            [
                "status" => "authorized",
                "created_at" => "2019-07-01T17:15:49-03:00"
            ],
            [
                "status" => "pending",
                "created_at" => "2019-07-01T17:15:49-03:00"
            ],
        ];
        $refunds = [
            [
                "status" => "refunded",
                "requester" => "rakuten",
                "reason" => "Errado",
                "payments" => [
                "status" => "refunded",
                "id" => "fake-payment-id",
                "amount" => 200.0,
              ], 
              "id" => "7766703d-d33c-4fbd-871b-01a93b1511ef",
              "created_at" => "2019-07-01T17:30:35-03:00",
              "amount" => "200.0",
            ]
        ];

        $this->refund->setChargeId($chargeId);
        $this->refund->setStatus($status);
        $this->refund->setResponse($response);
        $this->refund->setMessage('');
        $this->refund->setStatusHistory($statusHistory);
        $this->refund->setRefunds($refunds);

        $this->assertInstanceOf(Refund::class, $this->refund);
        $this->assertInstanceOf(Response::class, $this->refund->getResponse());
        $this->assertEquals($chargeId, $this->refund->getChargeId(), "Refund Transaction Charge UUID");
        $this->assertEquals($status, $this->refund->getStatus(), "Refund Transaction Status");
        $this->assertEmpty($this->refund->getMessage());
        $this->assertCount(1, $this->refund->getRefunds(), "Refund Transaction Refunds array");
        $this->assertCount(4, $this->refund->getStatusHistory(), "Refund Transaction Status History array");
    }
}
