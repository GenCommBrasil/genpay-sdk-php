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
use GenComm\Parser\GenPay\Transaction\Checkout;
use GenComm\Service\Http\Response\Response;
use GenComm\Enum\Status;

class CheckoutTest extends TestCase
{
    /**
     * @var Checkout
     */
    private $checkout;

    public function setUp()
    {
        $this->checkout = new Checkout();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $result = "fake-result";
        $installments = [
            [
                "total" => 5149.5,
                "quantity" => 1,
                "interest_percent" => 2.99,
                "interest_amount" => 149.5,
                "installment_amount" => 5149.5,
            ],
            [
                "total" => 5226.5,
                "quantity" => 2,
                "interest_percent" => 4.53,
                "interest_amount" => 226.5,
                "installment_amount" => 2613.25,
            ]
        ];
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult(json_encode($installments));

        $this->checkout->setResult($result);
        $this->checkout->setInstallments($installments);
        $this->checkout->setResponse($response);
        $this->checkout->setMessage('');

        $this->assertInstanceOf(Checkout::class, $this->checkout);
        $this->assertInstanceOf(Response::class, $this->checkout->getResponse());
        $this->assertCount(2, $this->checkout->getInstallments(), "Checkout Transaction - Count Installments");
        $this->assertEquals($result, $this->checkout->getResult(), "Checkout Transaction Result");
        $this->assertEmpty($this->checkout->getMessage());
    }
}
