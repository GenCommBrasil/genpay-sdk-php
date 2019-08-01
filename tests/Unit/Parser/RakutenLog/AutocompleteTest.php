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

namespace Rakuten\Tests\Unit\Parser\RakutenLog;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\Error;
use Rakuten\Connector\Parser\RakutenLog\Autocomplete;
use Rakuten\Connector\Service\Http\Response\Response;
use Rakuten\Connector\Service\Http\Webservice;

class AutocompleteTest extends TestCase
{
    public function testShouldSucceedAndReturnTransactionAutocomplete()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult($this->getDataSuccess());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();

        $stubWebservice->expects($this->exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $response = Autocomplete::success($stubWebservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenLog\Transaction\Autocomplete::class, $response);
        $this->assertFalse($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('Rua Bela Cintra', $response->getStreet(), "Autocomplete Street");
        $this->assertEquals('Consolação', $response->getDistrict(), "Autocomplete District");
        $this->assertEquals('São Paulo', $response->getCity(), "Autocomplete City");
        $this->assertEquals('SP', $response->getState(), "Autocomplete State");
        $this->assertEquals('01415001', $response->getZipcode(), "Autocomplete Zipcode");
        $this->assertEmpty($response->getMessage(), "Autocomplete Message");
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $response = new Response();
        $response->setStatus(Status::BAD_REQUEST);
        $response->setResult($this->getDataError());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();

        $stubWebservice->expects($this->exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $response = Autocomplete::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertTrue($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('ERROR', $response->getCode(), "Code Error");
        $this->assertEquals("CEP  não está em um formato correto! Ex.: 00000000 (sem traço)", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
    {
        $jsonSuccess = '
        {
          "status": "OK",
          "messages": [],
          "content": {
            "street": "Rua Bela Cintra",
            "district": "Consolação",
            "city": "São Paulo",
            "state": "SP",
            "zipcode": "01415001"
          }
        }';

        return $jsonSuccess;
    }

    /**
     * @return string
     */
    protected function getDataError()
    {
        $jsonError = '
        {
          "status": "ERROR",
          "messages": [
            {
              "type": "ERROR",
              "text": "CEP  não está em um formato correto! Ex.: 00000000 (sem traço)"
            }
          ]
        }                       
        ';

        return $jsonError;
    }
}
