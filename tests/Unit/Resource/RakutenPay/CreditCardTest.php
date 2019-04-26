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

namespace Rakuten\Tests\Unit\Resource\RakutenPay;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Resource\RakutenPay\CreditCard;

class CreditCardTest extends TestCase
{
    /**
     * @var CreditCard
     */
    private $creditCard;

    public function setUp()
    {
        $stub = $this->createMock(RakutenPay::class);
        $this->creditCard = new CreditCard($stub);
    }

    public function testItShouldInstanceOfCreditCard()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenPay\CreditCard", $this->creditCard);
    }

    public function testReturnDataStdClass()
    {
        $amount = 200;
        $token = "ASD7A89D73987DSDAS7D9D7832987A89DASDISADIUFHEUW=3423423233";
        $reference = "Pedido#01";
        $installmentsQuantity = 10;
        $holderName = "MARIA";
        $holderDocument = "12345678909";
        $cvv = "123";
        $brand = "AMEX";

        $this->creditCard->setToken($token);
        $this->creditCard->setReference($reference);
        $this->creditCard->setInstallmentsQuantity($installmentsQuantity);
        $this->creditCard->setHolderName($holderName);
        $this->creditCard->setHolderDocument($holderDocument);
        $this->creditCard->setCvv($cvv);
        $this->creditCard->setBrand($brand);
        $this->creditCard->setAmount($amount);
        $this->creditCard->setInstallmentInterest(
            1,
            0,
            200,
            200,
            200
        );
        $data = $this->creditCard->getData();

        $this->assertInstanceOf(\stdClass::class, $data);
        $this->assertEquals($amount, $data->amount, "Amount Credit Card");
        $this->assertEquals("credit_card", $data->method, "Payment Method Credit Card");
        $this->assertEquals($token, $data->token, "Token Credit Card");
        $this->assertEquals($reference, $data->reference, "Reference Method Credit Card");
        $this->assertEquals($installmentsQuantity, $data->installments_quantity, "Installments Quantity Method Credit Card");
        $this->assertEquals($holderName, $data->holder_name, "Holder Name Method Credit Card");
        $this->assertEquals($holderDocument, $data->holder_document, "Holder Document Method Credit Card");
        $this->assertEquals($cvv, $data->cvv, "CVV Method Credit Card");
        $this->assertEquals($brand, $data->brand, "CVV Method Credit Card");
    }
}