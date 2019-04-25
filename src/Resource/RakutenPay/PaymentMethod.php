<?php

namespace Rakuten\Connector\Resource\RakutenPay;

interface PaymentMethod
{
    /**
     * PaymentMethod Billet.
     *
     * @const string
     */
    const BILLET = 'billet';

    /**
     * PaymentMethod Credit Card.
     *
     * @const string
     */
    const CREDIT_CARD = 'credit_card';
}