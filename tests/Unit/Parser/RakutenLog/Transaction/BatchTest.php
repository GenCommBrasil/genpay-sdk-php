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

namespace Rakuten\Tests\Unit\Parser\RakutenLog\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\RakutenLog\Transaction\Batch;
use Rakuten\Connector\Service\Http\Response\Response;

class BatchTest extends TestCase
{
    /**
     * @var Batch
     */
    private $batch;

    public function setUp()
    {
        $this->batch = new Batch();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $response = new Response();
        $response->setStatus(Status::OK);
        $response->setResult("Batch Transaction Response");

        $status = "OK";
        $code = "fake-code";
        $trackingUrl = "fake-tracking-url";
        $printUrl = "fake-print-url";

        $this->batch->setStatus($status);
        $this->batch->setCode($code);
        $this->batch->setTrackingUrl($trackingUrl);
        $this->batch->setPrintUrl($printUrl);
        $this->batch->setResponse($response);
        $this->batch->setMessage('');

        $this->assertInstanceOf(Batch::class, $this->batch);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($status, $this->batch->getStatus(), "Batch Status Result");
        $this->assertEquals($code, $this->batch->getCode(), "Batch Code Result");
        $this->assertEquals($trackingUrl, $this->batch->getTrackingUrl(), "Batch Tracking URL");
        $this->assertEquals($printUrl, $this->batch->getPrintUrl(), "batch Print URL");
        $this->assertEquals(Status::OK, $this->batch->getResponse()->getStatus());
        $this->assertEmpty($this->batch->getMessage());
    }
}
