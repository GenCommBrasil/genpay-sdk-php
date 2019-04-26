<?php

namespace Rakuten\Connector\Enum;

/**
 * Class Endpoint
 * @package Rakuten\Connector\Enum
 */
class Endpoint
{
    const SANDBOX = 'https://oneapi-sandbox.rakutenpay.com.br/';
    const PRODUCTION = 'https://api.rakuten.com.br/';

    const DIRECT_PAYMENT = 'rpay/v1/charges';
    const CHECKOUT = 'rpay/v1/checkout';

    /**
     * @var array
     */
    private static $environment = [
        Environment::SANDBOX => self::SANDBOX,
        Environment::PRODUCTION => self::PRODUCTION,
    ];

    /**
     * @param $environment
     * @return mixed
     */
    public static function createChargeUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::DIRECT_PAYMENT : $environment;
    }

    /**
     * @param $environment
     * @return mixed
     */
    public static function buildCheckoutUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::CHECKOUT : $environment;
    }
}