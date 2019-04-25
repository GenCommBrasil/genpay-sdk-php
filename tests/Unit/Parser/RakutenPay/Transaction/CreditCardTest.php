<?php
namespace Rakuten\Tests\Unit\Parser\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\RakutenPay\Transaction\CreditCard;

class CreditCardTest extends TestCase
{
    /**
     * @var CreditCard
     */
    private $creditCard;

    public function setUp()
    {
        $this->creditCard = new CreditCard();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $result = "fake-result";
        $chargeId = "fake-charge-uuid";
        $creditCardNum = "411111*********1111111";
        $status = "processing";


        $this->creditCard->setResult($result);
        $this->creditCard->setChargeId($chargeId);
        $this->creditCard->setCreditCardNum($creditCardNum);
        $this->creditCard->setStatus($status);

        $this->assertInstanceOf(CreditCard::class, $this->creditCard);
        $this->assertEquals($result, $this->creditCard->getResult(), "Credit Card Transaction Result");
        $this->assertEquals($chargeId, $this->creditCard->getChargeId(), "Credit Card Transaction Charge UUID");
        $this->assertEquals($creditCardNum, $this->creditCard->getCreditCardNum(), "Credit Card Transaction Number With Mask");
        $this->assertEquals($status, $this->creditCard->getStatus(), "Credit Card Transaction Status");
    }
}
