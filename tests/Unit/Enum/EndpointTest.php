<?php
namespace Rakuten\Tests\Unit\Enum;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Endpoint;

/**
 * Class EnvironmentTest
 * @package Rakuten\Tests
 */
class EndpointTest extends TestCase
{
    public function testUrlsForCreateCharge()
    {
        $sandbox = Endpoint::SANDBOX . Endpoint::DIRECT_PAYMENT;
        $production = Endpoint::PRODUCTION . Endpoint::DIRECT_PAYMENT;
        $this->assertEquals($sandbox, Endpoint::createChargeUrl('sandbox'), 'URL in Sandbox');
        $this->assertEquals($production, Endpoint::createChargeUrl('production'), 'URL in production');
    }

    public function testUrlsForCheckout()
    {
        $sandbox = Endpoint::SANDBOX . Endpoint::CHECKOUT;
        $production = Endpoint::PRODUCTION . Endpoint::CHECKOUT;
        $this->assertEquals($sandbox, Endpoint::buildCheckoutUrl('sandbox'), 'URL in Sandbox');
        $this->assertEquals($production, Endpoint::buildCheckoutUrl('production'), 'URL in production');
    }
}
