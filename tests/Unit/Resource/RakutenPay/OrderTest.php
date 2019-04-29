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
use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\RakutenPay;
use Rakuten\Connector\Resource\RakutenPay\Order;

class OrderTest extends TestCase
{
    /**
     * @var Order
     */
    private $order;

    public function setUp(): void
    {
        $stub = $this->createMock(RakutenPay::class);
        $this->order = new Order($stub);
    }

    public function testItShouldInstanceOfOrder()
    {
        $this->assertInstanceOf("Rakuten\Connector\Resource\RakutenPay\Order", $this->order);
    }

    public function testReturnDataStdClass()
    {
        $amount = 700.00;
        $currency = "BRL";
        $fingerprint = "c9a3374e5b564eca2e734a81c01f0a54-fodm1ud7nrejul9x1d7";
        $webhookUrl = "http://localhost/teste/teste/sdk/";
        $reference = "Pedido#001";
        $itemsAmount = 700;
        $payerIp = "127.0.0.1";
        $taxesAmount = 0;
        $shippingAmount = 0;
        $discountAmount = 0;

        $this->order->setAmount($amount);
        $this->order->setCurrency($currency);
        $this->order->setFingerprint($fingerprint);
        $this->order->setWebhookUrl($webhookUrl);
        $this->order->setReference($reference);
        $this->order->setItemsAmount($itemsAmount);
        $this->order->setPayerIp($payerIp);
        $this->order->setTaxesAmount($taxesAmount);
        $this->order->setShippingAmount($shippingAmount);
        $this->order->setDiscountAmount($discountAmount);
        $this->order->addItem(
                $reference,
                "NIKE TENIS",
                1,
                200.0,
            200
            )
            ->addItem(
                $reference,
                "SAPATO BUTTS MAN",
                5,
                100,
                500
            );
        ;
        $data = $this->order->getData();
        $order = $data->order;

        $this->assertInstanceOf(\stdClass::class, $data);
        $this->assertInstanceOf(\stdClass::class, $order);
        $this->assertEquals($amount, $data->amount, "Amount from Order");
        $this->assertEquals($currency, $data->currency, "Currency BRL Basic Data - Order");
        $this->assertEquals($fingerprint, $data->fingerprint, "Fingerprint Basic Data -  Order");
        $this->assertEquals($reference, $data->reference, "Reference from Order");
        $this->assertEquals($webhookUrl, $data->webhook_url, "Webhook URL from Order");
        $this->assertEquals($itemsAmount, $order->items_amount, "Items Amount from Order");
        $this->assertEquals($payerIp, $order->payer_ip, "IP from Order");
        $this->assertEquals($taxesAmount, $order->taxes_amount, "Taxes Amount from Order");
        $this->assertEquals($shippingAmount, $order->shipping_amount, "Shipping Amount from Order");
        $this->assertEquals($discountAmount, $order->discount_amount, "Discount Amount from Order");
        $this->assertCount(2, $order->items, "Count Items");
    }

    public function testExceptionForNumberItems()
    {
        $reference = "Pedido#001";
        $this->expectException(RakutenException::class);
        $this->expectExceptionMessage("A quantidade do item deve ser um valor inteiro maior que 0");

        $this->order->addItem(
                $reference,
                "NIKE TENIS",
                0,
                200.0,
            200
            );
    }
}