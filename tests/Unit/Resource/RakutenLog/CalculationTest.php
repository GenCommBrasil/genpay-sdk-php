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

namespace Rakuten\Tests\Unit\Resource\RakutenLog;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\RakutenLog;
use Rakuten\Connector\Resource\RakutenLog\Calculation;

class CalculationTest extends TestCase
{
    /**
     * @var Calculation
     */
    private $calculation;

    public function setUp()
    {
        $stub = $this->createMock(RakutenLog::class);
        $this->calculation = new Calculation($stub);
    }

    public function testItShouldInstanceOfcalculation()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenLog\Calculation", $this->calculation);
    }

    public function testReturnDataStdClass()
    {
        $this->calculation->setDestinationZipcode("099990-000");
        $this->calculation->setPostageServiceCodes(array());
        $this->calculation->addProducts(
            '1',
            'TENIS NIKE',
            1,
            50,
            1,
            1,
            1,
            1
        );
        
        
        /** @var \stdClass $data */
        $data = $this->calculation->getData();

        $this->assertInstanceOf(\stdClass::class, $data);
    }
}