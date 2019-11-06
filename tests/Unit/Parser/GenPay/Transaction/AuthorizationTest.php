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
use GenComm\Parser\GenPay\Transaction\Authorization;
use GenComm\Service\Http\Response\Response;

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
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Authorization Transaction Response");

        $this->authorization->setMessage("Authorization Transaction Response");
        $this->authorization->setResponse($response);

        $this->assertInstanceOf(Authorization::class, $this->authorization);
        $this->assertInstanceOf(Response::class, $this->authorization->getResponse());
        $this->assertEquals(Status::OK, $this->authorization->getResponse()->getStatus(), "Authorization Transaction Status");
        $this->assertEquals($this->authorization->getMessage(), "Authorization Transaction Response");
    }
}
