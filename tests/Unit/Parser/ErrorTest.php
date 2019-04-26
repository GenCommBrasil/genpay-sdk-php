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
use Rakuten\Connector\Parser\Error;

class ErrorTest extends TestCase
{
    public function testMethodsGettersAndSetters()
    {
        $code = "123";
        $message = "Sum of payments amount doesn't match with amount";

        $error = new Error();

        $error->setCode($code)
            ->setMessage($message);

        $this->assertEquals($code, $error->getCode(), "Return Code from error");
        $this->assertEquals($message, $error->getMessage(), "Return Message from error");
    }
}