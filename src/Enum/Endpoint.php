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

namespace Rakuten\Connector\Enum;

/**
 * Class Endpoint
 * @package Rakuten\Connector\Enum
 */
class Endpoint
{
    const URL_SEPARATOR = '/';

    const SANDBOX = 'https://oneapi-sandbox.rakutenpay.com.br/';
    const PRODUCTION = 'https://api.rakuten.com.br/';

    const DIRECT_PAYMENT = 'rpay/v1/charges';
    const CHECKOUT = 'rpay/v1/checkout';

    const CANCEL = 'cancel';
    const REFUND = 'refund';
    const REFUND_PARTIAL = 'refund_partial';

    /**
     * @var array
     */
    private static $environment = [
        Environment::SANDBOX => self::SANDBOX,
        Environment::PRODUCTION => self::PRODUCTION,
    ];

    /**
     * @param $environment
     * @return string
     */
    public static function createChargeUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::DIRECT_PAYMENT : $environment;
    }

    /**
     * @param $environment
     * @return string
     */
    public static function buildCheckoutUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::CHECKOUT : $environment;
    }

    /**
     * @param $environment
     * @return string
     */
    public static function authorizationUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::DIRECT_PAYMENT : $environment;
    }

    /**
     * @param $environment
     * @param $chargeId
     * @return string
     */
    public static function buildCancelUrl($environment, $chargeId)
    {
        $chargeUrl = self::createChargeUrl($environment);

        return $chargeUrl . self::URL_SEPARATOR . $chargeId . self::URL_SEPARATOR . self::CANCEL;
    }

    /**
     * @param $environment
     * @param $chargeId
     * @return string
     */
    public static function buildRefundUrl($environment, $chargeId)
    {
        $chargeUrl = self::createChargeUrl($environment);

        return $chargeUrl . self::URL_SEPARATOR . $chargeId . self::URL_SEPARATOR . self::REFUND;
    }

    /**
     * @param $environment
     * @param $chargeId
     * @return string
     */
    public static function buildRefundPartialUrl($environment, $chargeId)
    {
        $chargeUrl = self::createChargeUrl($environment);

        return $chargeUrl . self::URL_SEPARATOR . $chargeId . self::URL_SEPARATOR . self::REFUND_PARTIAL;
    }

}