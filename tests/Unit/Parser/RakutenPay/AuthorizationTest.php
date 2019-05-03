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

namespace Rakuten\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Parser\RakutenPay\Authorization;
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\RakutenPay;

class AuthorizationTest extends TestCase
{
    /**
     * @var Webservice
     */
    private $webservice;

    public function setUp()
    {
        $stub = $this->getMockBuilder(RakutenPay::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->webservice = new Webservice($stub);
    }

    public function testShouldSucceedAndReturnAuthorizationBillet()
    {
        $this->webservice->setStatus(Status::OK);
        $this->webservice->setResponse($this->getDataSuccess());

        $response = Authorization::success($this->webservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenPay\Transaction\Authorization::class, $response);
        $this->assertEquals(Status::OK, $response->getStatus(), "Authorization return Status");
        $this->assertTrue($response->getMessage(), "Authorization Response");
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $this->webservice->setStatus(Status::FORBIDDEN);
        $this->webservice->setResponse("store_not_found");

        $response = Authorization::error($this->webservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertEquals(Status::FORBIDDEN, $response->getCode(), "Code Status");
        $this->assertEquals("store_not_found", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
    {
        $jsonSuccess = '
        {
          "result": "success",
          "charges": []
        }';

        return $jsonSuccess;
    }
}
