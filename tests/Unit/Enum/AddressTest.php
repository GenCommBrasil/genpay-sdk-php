<?php
namespace Rakuten\Tests\Unit\Enum;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Address;

/**
 * Class AddressTest
 * @package Rakuten\Tests
 */
class AddressTest extends TestCase
{
    public function testAllConstants()
    {
        $this->assertEquals("billing", Address::ADDRESS_BILLING, "String lowcase billing");
        $this->assertEquals("shipping", Address::ADDRESS_SHIPPING, "String lowcase shipping");
        $this->assertEquals("BRA", Address::ADDRESS_COUNTRY, "String uppercase Country BRA");
    }
}