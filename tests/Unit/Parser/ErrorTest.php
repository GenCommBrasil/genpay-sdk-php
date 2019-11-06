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

namespace GenComm\Tests\Unit\Parser;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Status;
use GenComm\Parser\Error;
use GenComm\Service\Http\Response\Response;

class ErrorTest extends TestCase
{
    public function testMethodsGettersAndSetters()
    {
        $code = "1011";
        $message = "credit_card_info missing required field(s): installments_quantity, brand and/or token";

        $error = new Error();
        $response = new Response();
        $response->setStatus(Status::OK)
            ->setResult($this->getResponseError());

        $error->setCode($code)
            ->setMessage($message)
            ->setResponse($response);

        $this->assertEquals($code, $error->getCode(), "Return Code from error");
        $this->assertEquals($message, $error->getMessage(), "Return Message from error");
        $this->assertInstanceOf('GenComm\Service\Http\Response\Response', $error->getResponse());
    }

    /**
     * @return string
     */
    private function getResponseError()
    {
        return '
            {
              "result_messages": [
                "credit_card_info missing required field(s): installments_quantity, brand and/or token"
              ],
              "result_code": {
                "message_error": [
                  "credit_card_info missing required field(s): installments_quantity, brand and/or token"
                ],
                "id": "charge_validation",
                "code": 1011
              },
              "result": "failure",
              "reference": "",
              "payments": [],
              "charge_uuid": ""
            }';
    }
}