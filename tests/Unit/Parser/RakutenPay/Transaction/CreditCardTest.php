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

namespace Rakuten\Tests\Unit\Parser\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\RakutenPay\Transaction\CreditCard;

class CreditCardTest extends TestCase
{
    /**
     * @var CreditCard
     */
    private $creditCard;

    public function setUp(): void
    {
        $this->creditCard = new CreditCard();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $result = "fake-result";
        $chargeId = "fake-charge-uuid";
        $creditCardNum = "411111*********1111111";
        $status = "processing";


        $this->creditCard->setResult($result);
        $this->creditCard->setChargeId($chargeId);
        $this->creditCard->setCreditCardNum($creditCardNum);
        $this->creditCard->setStatus($status);

        $this->assertInstanceOf(CreditCard::class, $this->creditCard);
        $this->assertEquals($result, $this->creditCard->getResult(), "Credit Card Transaction Result");
        $this->assertEquals($chargeId, $this->creditCard->getChargeId(), "Credit Card Transaction Charge UUID");
        $this->assertEquals($creditCardNum, $this->creditCard->getCreditCardNum(), "Credit Card Transaction Number With Mask");
        $this->assertEquals($status, $this->creditCard->getStatus(), "Credit Card Transaction Status");
    }
}
