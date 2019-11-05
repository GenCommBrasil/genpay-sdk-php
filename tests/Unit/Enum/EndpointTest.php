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

namespace GenComm\Tests\Unit\Enum;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Endpoint;

/**
 * Class EnvironmentTest
 * @package GenComm\Tests
 */
class EndpointTest extends TestCase
{
    public function testUrlsForCreateCharge()
    {
        $sandbox = Endpoint::SANDBOX . Endpoint::RAKUTENPAY_DIRECT_PAYMENT;
        $production = Endpoint::PRODUCTION . Endpoint::RAKUTENPAY_DIRECT_PAYMENT;
        $this->assertEquals($sandbox, Endpoint::createChargeUrl('sandbox'), 'URL in Sandbox');
        $this->assertEquals($production, Endpoint::createChargeUrl('production'), 'URL in production');
    }

    public function testUrlsForCheckout()
    {
        $sandbox = Endpoint::SANDBOX . Endpoint::RAKUTENPAY_CHECKOUT;
        $production = Endpoint::PRODUCTION . Endpoint::RAKUTENPAY_CHECKOUT;
        $this->assertEquals($sandbox, Endpoint::buildCheckoutUrl('sandbox'), 'URL in Sandbox');
        $this->assertEquals($production, Endpoint::buildCheckoutUrl('production'), 'URL in production');
    }
}
