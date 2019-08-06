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
use Rakuten\Connector\Resource\RakutenLog\Batch;

class BatchTest extends TestCase
{
    /**
     * @var Batch
     */
    private $batch;

    public function setUp()
    {
        $stub = $this->createMock(RakutenLog::class);
        $this->batch = new Batch($stub);
    }

    public function testItShouldInstanceOfBatch()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenLog\Batch", $this->batch);
    }

    public function testReturnDataStdClass()
    {
        $this->batch->setCalculationCode("fake-calculation-code");
        $this->batch->setPostageServiceCode("fake-postage-service-code");
        $this->batch->setOrder("1666000041", "1666000041", 200.83);
        $this->batch->setCustomer("Teste", "Da Silva", "12345678909");
        $this->batch->setInvoice(
            "1",
            "123",
            "API-01",
            "ASDSD-ASDSAD",
            "2019-01-01",
            1.0,
            2.0,
            1.0,
            1
        );
        $this->batch->setDeliveryAddress(
            "Teste",
            "TEste da Silva",
            "Rua Capanema",
            "500",
            "Torre New York 6 Andar",
            "Rua dos Piao",
            "Rio de Janeiro",
            "SP",
            "21920070",
            "teste@teste.com.br",
            "1144556677",
            "1155667788"
        );

        /** @var \stdClass $data */
        $data = $this->batch->getData();

        $this->assertInstanceOf(\stdClass::class, $data);
    }
}