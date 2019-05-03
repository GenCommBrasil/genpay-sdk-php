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
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Authorization;

class AuthorizationTest extends TestCase
{
    /**
     * @var Authorization
     */
    private $authorization;

    public function setUp()
    {
        $this->authorization = new Authorization();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $status = Status::OK;
        $response = true;
        
        $this->authorization->setStatus($status);
        $this->authorization->setMessage($response);

        $this->assertInstanceOf(Authorization::class, $this->authorization);
        $this->assertEquals(Status::OK, $this->authorization->getStatus(), "Authorization Transaction Status");
        $this->assertTrue($this->authorization->getMessage(), "Authorization Transaction Response");
    }
}
