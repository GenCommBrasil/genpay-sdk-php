<?php
namespace Rakuten\Tests\Unit\Parser\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Billet;

class BilletTest extends TestCase
{
    /**
     * @var Billet
     */
    private $billet;

    public function setUp()
    {
        $this->billet = new Billet;
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $result = "fake-result";
        $chargeId = "fake-charge-uuid";
        $billet = "fake-billet-download";
        $billetUrl = "fake-billet-url";

        $this->billet->setResult($result);
        $this->billet->setChargeId($chargeId);
        $this->billet->setBillet($billet);
        $this->billet->setBilletUrl($billetUrl);

        $this->assertInstanceOf(Billet::class, $this->billet);
        $this->assertEquals($result, $this->billet->getResult(), "Billet Transaction Result");
        $this->assertEquals($chargeId, $this->billet->getChargeId(), "Billet Transaction Charge UUID");
        $this->assertEquals($billet, $this->billet->getBillet(), "Billet Transaction URL Download Billet");
        $this->assertEquals($billetUrl, $this->billet->getBilletUrl(), "Billet Transaction URL Billet");
    }
}
