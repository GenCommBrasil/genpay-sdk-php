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
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Resource\RakutenPay\Billet;

class BilletTest extends TestCase
{
    /**
     * @var Billet
     */
    private $billet;

    public function setUp()
    {
        $stub = $this->createMock(RakutenPay::class);
        $this->billet = new Billet($stub);
    }

    public function testItShouldInstanceOfBillet()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenPay\Billet", $this->billet);
    }

    public function testReturnDataStdClass()
    {
        $amount = 200;
        $expiresOn = "1980-01-01";

        $this->billet->setAmount($amount);
        $this->billet->setExpiresOn($expiresOn);
        /** @var \stdClass $data */
        $data = $this->billet->getData();

        $this->assertInstanceOf(\stdClass::class, $data);
        $this->assertEquals($amount, $data->amount, "Amount Billet");
        $this->assertEquals("billet", $data->method, "Payment Method Billet");
        $this->assertEquals($expiresOn, $data->expires_on, "Expires On Billet");
    }
}