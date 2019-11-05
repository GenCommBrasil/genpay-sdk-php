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
use GenComm\Enum\Status;
use GenComm\Parser\GenPay\Transaction\Billet;
use GenComm\Service\Http\Response\Response;

class BilletTest extends TestCase
{
    /**
     * @var Billet
     */
    private $billet;

    public function setUp()
    {
        $this->billet = new Billet;
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Authorization Transaction Response");

        $result = "fake-result";
        $chargeId = "fake-charge-uuid";
        $paymentId = "fake-payment-id";
        $billet = "fake-billet-download";
        $billetUrl = "fake-billet-url";

        $this->billet->setResult($result);
        $this->billet->setChargeId($chargeId);
        $this->billet->setPaymentId($paymentId);
        $this->billet->setBillet($billet);
        $this->billet->setBilletUrl($billetUrl);
        $this->billet->setMessage('');
        $this->billet->setResponse($response);

        $this->assertInstanceOf(Billet::class, $this->billet);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($result, $this->billet->getResult(), "Billet Transaction Result");
        $this->assertEquals($chargeId, $this->billet->getChargeId(), "Billet Transaction Charge UUID");
        $this->assertEquals($paymentId, $this->billet->getPaymentId(), "Billet Payment ID");
        $this->assertEquals($billet, $this->billet->getBillet(), "Billet Transaction URL Download Billet");
        $this->assertEquals($billetUrl, $this->billet->getBilletUrl(), "Billet Transaction URL Billet");
        $this->assertEmpty($this->billet->getMessage());
    }
}
