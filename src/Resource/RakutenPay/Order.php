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

namespace Rakuten\Connector\Resource\RakutenPay;

use Rakuten\Connector\Exception\RakutenException;
use Rakuten\Connector\RakutenConnector;
use stdClass;

/**
 * Class Order
 * @package Rakuten\Connector\Resource\RakutenPay
 */
class Order extends RakutenPayResource
{
    /**
     * @var array
     */
    private $categoryDefault = [
        'name' => 'Outros',
        'id' => '99'
    ];

    /**
     * @inheritdoc
     */
    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->order = new stdClass();
        $this->data->order->items = [];
    }

    /**
     * Adds a new item to order.
     *
     * @param string $reference
     * @param string $description
     * @param int $quantity
     * @param float $amount
     * @param float $totalAmount
     * @param array $categories
     * @return $this
     * @throws RakutenException
     */
    public function addItem($reference, $description, $quantity, $amount, $totalAmount, array $categories = [])
    {
        if (!is_int($quantity) || $quantity < 1) {
            throw new RakutenException('A quantidade do item deve ser um valor inteiro maior que 0');
        }

        if (!count($categories)) {
            $categories = $this->categoryDefault;
        }

        $item = new stdClass();
        $item->total_amount = (float) $totalAmount;
        $item->reference = $reference;
        $item->description = $description;
        $item->quantity = (int) $quantity;
        $item->categories[] = $categories;
        $item->amount = (float) $amount;
        $this->data->order->items[] = $item;

        return $this;
    }

    /**
     * @param float $taxesAmount
     * @return $this
     */
    public function setTaxesAmount($taxesAmount)
    {
        $this->data->order->taxes_amount = (float) $taxesAmount;

        return $this;
    }

    /**
     * @param float $shippingAmount
     * @return $this
     */
    public function setShippingAmount($shippingAmount)
    {
        $this->data->order->shipping_amount = (float) $shippingAmount;

        return $this;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->data->reference = $reference;
        $this->data->order->reference = $reference;

        return $this;
    }

    /**
     * @param string $payerIp
     * @return $this
     */
    public function setPayerIp($payerIp)
    {
        $this->data->order->payer_ip = $payerIp;

        return $this;
    }

    /**
     * @param float $itemsAmount
     * @return $this
     */
    public function setItemsAmount($itemsAmount)
    {
        $this->data->order->items_amount = (float) $itemsAmount;

        return $this;
    }

    /**
     * @param float $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->data->order->discount_amount = (float) $discountAmount;

        return $this;
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency = RakutenConnector::CURRENCY)
    {
        $this->data->currency = $currency;

        return $this;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->data->amount = (float) $amount;

        return $this;
    }

    /**
     * @param string $fingerprint
     * @return $this
     */
    public function setFingerprint($fingerprint)
    {
        $this->data->fingerprint = $fingerprint;

        return $this;
    }

    /**
     * @param string $webhookUrl
     * @return $this
     */
    public function setWebhookUrl($webhookUrl)
    {
        $this->data->webhook_url = $webhookUrl;

        return $this;
    }
}
