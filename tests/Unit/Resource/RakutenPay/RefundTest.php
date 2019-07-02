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

namespace Rakuten\Tests\Unit\Resource\RakutenPay;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Refund\Requester;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Resource\RakutenPay\Refund;

class RefundTest extends TestCase
{
    /**
     * @var Refund
     */
    private $refund;

    public function setUp()
    {
        $stub = $this->createMock(RakutenPay::class);
        $this->refund = new Refund($stub);
    }

    public function testItShouldInstanceOfRefund()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenPay\Refund", $this->refund);
    }

    public function testReturnDataStdClass()
    {
        $paymentId = 'fake-payment-id';

        $amount = 200;
        $requester = Requester::RAKUTEN;
        $reason = 'Received product of wrong model';
        $bankAccount = [
            'document' => '11111111111',
            'bank_code' => '341',
            'bank_agency' => '1234',
            'bank_number' => '12345678-1',

        ];

        $this->refund->setRequester($requester);
        $this->refund->setReason($reason);
        $this->refund->addPayment($paymentId, $amount, $bankAccount);

        $data = $this->refund->getData();
        $payments = array_shift($data->payments);

        $this->assertInstanceOf(\stdClass::class, $data);
        $this->assertEquals($requester, $data->requester, "Refund Requester");
        $this->assertEquals($reason, $data->reason, "Refund Reason");
        $this->assertEquals($paymentId, $payments->id, "Refund Payment Id");
        $this->assertEquals($amount, $payments->amount, "Refund Amount");
        $this->assertCount(4, $payments->bank_account,"Refund Count Bank Account");
    }
}