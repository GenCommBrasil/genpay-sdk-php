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

namespace GenComm\Tests\Unit\Parser\GenPay\Transaction;

use PHPUnit\Framework\TestCase;
use GenComm\Parser\GenPay\Transaction\CreditCard;
use GenComm\Service\Http\Response\Response;
use GenComm\Enum\Status;

class CreditCardTest extends TestCase
{
    /**
     * @var CreditCard
     */
    private $creditCard;

    public function setUp()
    {
        $this->creditCard = new CreditCard();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Transaction OK");

        $result = "fake-result";
        $chargeId = "fake-charge-uuid";
        $paymentId = "fake-payment-id";
        $creditCardNum = "411111*********1111111";
        $status = "processing";

        $this->creditCard->setResult($result);
        $this->creditCard->setChargeId($chargeId);
        $this->creditCard->setPaymentId($paymentId);
        $this->creditCard->setCreditCardNum($creditCardNum);
        $this->creditCard->setStatus($status);
        $this->creditCard->setResponse($response);
        $this->creditCard->setMessage('');

        $this->assertInstanceOf(CreditCard::class, $this->creditCard);
        $this->assertInstanceOf(Response::class, $this->creditCard->getResponse());
        $this->assertEquals($result, $this->creditCard->getResult(), "Credit Card Transaction Result");
        $this->assertEquals($chargeId, $this->creditCard->getChargeId(), "Credit Card Transaction Charge UUID");
        $this->assertEquals($paymentId, $this->creditCard->getPaymentId(), "Credit Card Payment ID");
        $this->assertEquals($creditCardNum, $this->creditCard->getCreditCardNum(), "Credit Card Transaction Number With Mask");
        $this->assertEquals($status, $this->creditCard->getStatus(), "Credit Card Transaction Status");
        $this->assertEmpty($this->creditCard->getMessage());
    }
}
