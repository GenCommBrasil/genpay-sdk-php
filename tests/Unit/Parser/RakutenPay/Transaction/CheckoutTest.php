<?php
namespace Rakuten\Tests\Unit\Parser\Transaction;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Checkout;

class CheckoutTest extends TestCase
{
    /**
     * @var Checkout
     */
    private $checkout;

    public function setUp()
    {
        $this->checkout = new Checkout();
    }

    public function testItShouldValuesGettersAndSetters()
    {
        $result = "fake-result";
        $installments = [
            [
                "total" => 5149.5,
                "quantity" => 1,
                "interest_percent" => 2.99,
                "interest_amount" => 149.5,
                "installment_amount" => 5149.5,
            ],
            [
                "total" => 5226.5,
                "quantity" => 2,
                "interest_percent" => 4.53,
                "interest_amount" => 226.5,
                "installment_amount" => 2613.25,
            ]
        ];
        $method = "credit_card";

        $this->checkout->setResult($result);
        $this->checkout->setInstallments($installments);
        $this->checkout->setMethod($method);

        $this->assertInstanceOf(Checkout::class, $this->checkout);
        $this->assertCount(2, $this->checkout->getInstallments(), "Checkout Transaction - Count Installments");
        $this->assertEquals($result, $this->checkout->getResult(), "Checkout Transaction Result");
        $this->assertEquals($method, $this->checkout->getMethod(), "Checkout Transaction Method");
    }
}
