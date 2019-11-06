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

namespace GenComm\Tests\Unit\Parser\GenLog;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Status;
use GenComm\Parser\Error;
use GenComm\Parser\GenLog\Batch;
use GenComm\Service\Http\Response\Response;
use GenComm\Service\Http\Webservice;

class BatchTest extends TestCase
{
    public function testShouldSucceedAndReturnTransactionBatch()
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

        $response = Batch::success($stubWebservice);

        $this->assertInstanceOf(\GenComm\Parser\GenLog\Transaction\Batch::class, $response);
        $this->assertFalse($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('OK', $response->getStatus(), "Batch Status");
        $this->assertEquals('fake-code', $response->getCode(), "Batch Code");
        $this->assertEquals('fake-tracking-url', $response->getTrackingUrl(), "Batch Tracking URL");
        $this->assertEquals('fake-print-url', $response->getPrintUrl(), "Batch Expiration Date");
        $this->assertEmpty($response->getMessage(), "Batch Message");
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

        $response = Batch::error($stubWebservice);

        $this->assertInstanceOf(Error::class, $response);
        $this->assertTrue($response->isError());
        $this->assertInstanceOf(Response::class, $response->getResponse());
        $this->assertEquals('ERROR', $response->getCode(), "Code Error");
        $this->assertEquals("O cálculo código: 89798978979877-098908-9889-899 enviado não existe.", $response->getMessage(), "Error Message");
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
          "content": [
            {
              "warehouse": {},
              "tracking_objects": [
                {
                  "volume_number": 1,
                  "tracking_url": "fake-tracking-url",
                  "print_url": "fake-print-url",
                  "order_code": "17",
                  "number": "17"
                }
              ],
              "status_description": "Completo",
              "status": "Completed",
              "print_url": "https://logistics-sandbox.rakuten.com.br/print/#/batch/ea06ed55-fb0a-4f14-8d9b-e3ee7a7b3f41/6bbe787f-3c18-483e-8877-4b6c5a96b6b4",
              "errors": [],
              "code": "fake-code"
            }
          ]
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
              "text": "O cálculo código: 89798978979877-098908-9889-899 enviado não existe."
            }
          ]
        }                        
        ';

        return $jsonError;
    }
}
