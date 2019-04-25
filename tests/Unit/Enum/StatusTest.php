<?php
namespace Rakuten\Tests\Unit\Enum;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;

/**
 * Class StatusTest
 * @package Rakuten\Tests
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