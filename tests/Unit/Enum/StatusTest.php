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

namespace GenComm\Tests\Unit\Enum;

use PHPUnit\Framework\TestCase;
use GenComm\Enum\Status;

/**
 * Class StatusTest
 * @package GenComm\Tests
 */
class StatusTest extends TestCase
{
    public function testAllConstants()
    {
        $this->assertEquals(200, Status::OK, "Status OK");
        $this->assertEquals(400, Status::BAD_REQUEST, "Status bad request");
        $this->assertEquals(401, Status::UNAUTHORIZED, "Status unauthorized");
        $this->assertEquals(403, Status::FORBIDDEN, "Status forbidden");
        $this->assertEquals(422, Status::UNPROCESSABLE, "Status unprocessable entity");
        $this->assertEquals(500, Status::INTERNAL_SERVER_ERROR, "Status internal server error");
        $this->assertEquals(502, Status::BAD_GATEWAY, "Status bad gateway");
    }
}