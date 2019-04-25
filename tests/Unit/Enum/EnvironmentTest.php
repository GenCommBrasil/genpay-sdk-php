<?php
namespace Rakuten\Tests\Unit\Enum;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Environment;

/**
 * Class EnvironmentTest
 * @package Rakuten\Tests
 */
class EnvironmentTest extends TestCase
{
    public function testAllConstants()
    {
        $this->assertEquals('sandbox', Environment::ENVIRONMENT_SANDBOX, "Sandbox");
        $this->assertEquals('production', Environment::ENVIRONMENT_PRODUCTION, "Production");
    }
}
