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
use Rakuten\Connector\Service\Http\Webservice;
use Rakuten\Connector\RakutenPay;

class BilletTest extends TestCase
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

    public function testShouldSucceedAndReturnTransactionBillet()
    {
        $this->webservice->setStatus(200);
        $this->webservice->setResponse($this->getDataSuccess());

        $response = Billet::success($this->webservice);

        $this->assertInstanceOf(\Rakuten\Connector\Parser\RakutenPay\Transaction\Billet::class, $response);
        $this->assertEquals('fake-charge-uuid', $response->getChargeId(), "Charge UUID");
        $this->assertEquals('fake-download-url', $response->getBillet(), "Billet URL");
        $this->assertEquals('fake-url', $response->getBilletUrl(), "Billet URL");
    }

    public function testShouldErrorAndReturnErrorClass()
    {
        $this->webservice->setStatus(Status::UNPROCESSABLE);
        $this->webservice->setResponse($this->getDataError());

        $response = Billet::error($this->webservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertEquals(Status::UNPROCESSABLE, $response->getCode(), "Code Status");
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
