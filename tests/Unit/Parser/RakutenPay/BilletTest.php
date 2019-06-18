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
use Rakuten\Connector\Parser\RakutenPay\Billet;
use Rakuten\Connector\Service\Http\Response\Response;
use Rakuten\Connector\Service\Http\Webservice;

class BilletTest extends TestCase
{
    public function testShouldSucceedAndReturnTransactionBillet()
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

        $response = Billet::success($stubWebservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenPay\Transaction\Billet::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertEquals('fake-download-url', $response->getBillet(), "Billet URL");
        $this->assertEquals('fake-url', $response->getBilletUrl(), "Billet URL");
        $this->assertEmpty($response->getMessage(), "Billet Message");
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $response = new Response();
        $response->setStatus(Status::UNPROCESSABLE);
        $response->setResult($this->getDataError());

        $stubWebservice = $this->getMockBuilder(Webservice::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponse'])
            ->getMock();

        $stubWebservice->expects($this->exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $response = Billet::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals(999, $response->getCode(), "Code Status");
        $this->assertEquals("Sum of payments amount doesnt match with amount", $response->getMessage(), "Error Message");
    }

    /**
     * @return string
     */
    protected function getDataSuccess()
    {
        $jsonSuccess = '
        {  
           "shipping":{  
              "time":null,
              "kind":null,
              "company":null,
              "amount":0.0,
              "adjustments":[  
        
              ]
           },
           "result_messages":[  
        
           ],
           "result":"success",
           "reference":"SDK-4",
           "payments":[  
              {  
                 "status":"authorized",
                 "result_messages":[  
        
                 ],
                 "result":"success",
                 "refundable_amount":200.0,
                 "reference":"",
                 "method":"billet",
                 "id":"7bc839c5-991a-40a1-bcad-012c47f384ac",
                 "billet":{  
                    "url":"fake-url",
                    "number":"12805826",
                    "download_url":"fake-download-url"
                 },
                 "amount":200.0
              }
           ],
           "fingerprint":"fake-fingerprint",
           "commissionings":[  
        
           ],
           "charge_uuid":"fake-charge-uuid"
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
          "result_messages": [
            "Sum of payments amount doesnt match with amount"
          ],
          "result_code": {
            "message": [
              "Sum of payments amount doesnt match with amount"
            ],
            "code": 999
          },
          "result": "failure",
          "reference": "",
          "payments": [],
          "charge_uuid": ""
        }        
        ';

        return $jsonError;
    }
}
