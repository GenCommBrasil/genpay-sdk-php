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
use GenComm\Enum\Address;

/**
 * Class AddressTest
 * @package GenComm\Tests
 */
class AddressTest extends TestCase
{
    public function testAllConstants()
    {
        $this->assertEquals("billing", Address::ADDRESS_BILLING, "String lowcase billing");
        $this->assertEquals("shipping", Address::ADDRESS_SHIPPING, "String lowcase shipping");
        $this->assertEquals("BRA", Address::ADDRESS_COUNTRY, "String uppercase Country BRA");
    }

    /**
     * @dataProvider getStateProvider
     */
    public function testConversionStateToUF($value, $expected)
    {
        $this->assertEquals(Address::convertUf($value), $expected);
    }

    /**
     * @return array
     */
    public function getStateProvider()
    {
        return [
            ["São Paulo", "SP"],
            ["Rio de Janeiro", "RJ"],
            ["RJ", "RJ"],
            ["Amazonas", "AM"],
            ["PF", "PF"],
            ["", ""],
        ];
    }
}