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

namespace Rakuten\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Rakuten\Connector\Enum\Status;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Authorization;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Billet;
use Rakuten\Connector\Parser\RakutenPay\Transaction\Checkout;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Enum\Environment;
use Rakuten\Connector\Parser\Error;

/**
 * Class RakutenPayTest
 * @package Rakuten\Tests\Integration
 */
class RakutenPayTest extends TestCase
{
    public function testItShouldCreateOrder()
    {
        $reference = "SDK#" . md5(uniqid(rand(), true));
        $rakutenPay = new RakutenPay("77753821000123", "EBDB6843FAA9073B5AD1929A77CBF86B", "96D9F59946F0CBDBD7D1B0FB5F968AD6", Environment::SANDBOX);
        $order = $rakutenPay
            ->order()
            ->setAmount(200.0)
            ->setCurrency("BRL")
            ->setFingerprint("c9a3374e5b564eca2e734a81c01f0a54-fodm1ud7nrejul9x1d7")
            ->setWebhookUrl("http://intregation.test/sdk/")
            ->setReference($reference)
            ->setItemsAmount(200.0)
            ->setPayerIp("127.0.0.1")
            ->setTaxesAmount(0)
            ->setShippingAmount(0)
            ->setDiscountAmount(0)
            ->addItem(
                $reference,
                "NIKE TENIS",
                1,
                200.0,
                200.0
            );
        $customer = $rakutenPay
            ->customer()
            ->setName("Maria")
            ->setBirthDate("1985-04-16")
            ->setBusinessName("Maria")
            ->setDocument("12345678909")
            ->setEmail("teste@teste.com.br")
            ->setKind("personal")
            ->addAddress("shipping",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAddress("billing",
                "09840-500",
                "Rua Dos Morros",
                "1000",
                "ABC",
                "Maua",
                "SP",
                "Maria",
                "")
            ->addAPhones("55",
                "11",
                "999999998",
                "others",
                "shipping")
            ->addAPhones("55",
                "11",
                "999999998",
                "others",
                "billing");

        $payment = $rakutenPay
            ->asBillet()
            ->setAmount(200.0)
            ->setExpiresOn("3");

        /** @var Billet $response */
        $response = $rakutenPay->createOrder($order, $customer, $payment);

         $this->assertInstanceOf(Billet::class, $response, "Order Created");
    }

    public function testGetInterestInstallmentsForCheckout()
    {
        $rakutenPay = new RakutenPay("77753821000123", "EBDB6843FAA9073B5AD1929A77CBF86B", "96D9F59946F0CBDBD7D1B0FB5F968AD6", Environment::SANDBOX);

        $response = $rakutenPay->checkout(5000);

        $this->assertInstanceOf(Checkout::class, $response, "Order Created");
    }

    public function testItShouldAuthorizationIsReturnStatusOKAndResponseTrue()
    {
        $rakutenPay = new RakutenPay("77753821000123", "EBDB6843FAA9073B5AD1929A77CBF86B", "96D9F59946F0CBDBD7D1B0FB5F968AD6", Environment::SANDBOX);
        $response = $rakutenPay->authorizationValidate();

        $this->assertInstanceOf(Authorization::class, $response, "Authorization Class");
        $this->assertEquals(Status::OK, $response->getStatus(), "Authorization Status");
        $this->assertTrue($response->getMessage());
    }

    public function testItShouldAuthorizationNotAuthorized()
    {
        $rakutenPay = new RakutenPay("12345678909", "EBDB6843FAA9073B5AD1929A77CBF86B", "96D9F59946F0CBDBD7D1B0FB5F968AD6", Environment::SANDBOX);
        $response = $rakutenPay->authorizationValidate();

        $this->assertInstanceOf(Error::class, $response, "Error Class");
        $this->assertEquals(Status::FORBIDDEN, $response->getCode(), "Forbidden Status");
        $this->assertEquals("store_not_found", $response->getMessage(), "Error Message");
    }
}