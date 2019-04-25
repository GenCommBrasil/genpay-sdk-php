<?php
namespace Rakuten\Tests\Unit\Resource\RakutenPay;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Resource\RakutenPay\Billet;

class BilletTest extends TestCase
{
    /**
     * @var Billet
     */
    private $billet;

    public function setUp()
    {
        $stub = $this->createMock(RakutenPay::class);
        $this->billet = new Billet($stub);
    }

    public function testItShouldInstanceOfBillet()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenPay\Billet", $this->billet);
    }

    public function testReturnDataStdClass()
    {
        $amount = 200;
        $expiresOn = "1980-01-01";

        $this->billet->setAmount($amount);
        $this->billet->setExpiresOn($expiresOn);
        /** @var \stdClass $data */
        $data = $this->billet->getData();

        $this->assertInstanceOf(\stdClass::class, $data);
        $this->assertEquals($amount, $data->amount, "Amount Billet");
        $this->assertEquals("billet", $data->method, "Payment Method Billet");
        $this->assertEquals($expiresOn, $data->expires_on, "Expires On Billet");
    }
}