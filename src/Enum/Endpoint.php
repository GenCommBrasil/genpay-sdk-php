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

    const RAKUTENPAY_DIRECT_PAYMENT = 'rpay/v1/charges';
    const RAKUTENPAY_CHECKOUT = 'rpay/v1/checkout';

    const RAKUTENPAY_CANCEL = 'cancel';
    const RAKUTENPAY_REFUND = 'refund';
    const RAKUTENPAY_REFUND_PARTIAL = 'refund_partial';

    const RAKUTENLOG_CALCULATION = 'logistics/calculation';
    const RAKUTENLOG_AUTOCOMPLETE = 'logistics/zipcode';
    const RAKUTENLOG_AUTOCOMPLETE_ONLINE = 'logistics/zipcode/online';
    const RAKUTENLOG_BATCH = 'logistics/batch';

    /**
     * @var array
     */
    private static $environment = [
        Environment::SANDBOX => self::SANDBOX,
        Environment::PRODUCTION => self::PRODUCTION,
    ];

    /**
     * @param string$environment
     * @return string
     */
    public static function createChargeUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::RAKUTENPAY_DIRECT_PAYMENT : $environment;
    }

    /**
     * @param string $environment
     * @return string
     */
    public static function buildCheckoutUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::RAKUTENPAY_CHECKOUT : $environment;
    }

    /**
     * @param string $environment
     * @return string
     */
    public static function authorizationUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::RAKUTENPAY_DIRECT_PAYMENT : $environment;
    }

    /**
     * @param string $environment
     * @param string $chargeId
     * @return string
     */
    public static function buildCancelUrl($environment, $chargeId)
    {
        $chargeUrl = self::createChargeUrl($environment);

        return $chargeUrl . self::URL_SEPARATOR . $chargeId . self::URL_SEPARATOR . self::RAKUTENPAY_CANCEL;
    }

    /**
     * @param string $environment
     * @param string $chargeId
     * @return string
     */
    public static function buildRefundUrl($environment, $chargeId)
    {
        $chargeUrl = self::createChargeUrl($environment);

        return $chargeUrl . self::URL_SEPARATOR . $chargeId . self::URL_SEPARATOR . self::RAKUTENPAY_REFUND;
    }

    /**
     * @param string $environment
     * @param string $chargeId
     * @return string
     */
    public static function buildRefundPartialUrl($environment, $chargeId)
    {
        $chargeUrl = self::createChargeUrl($environment);

        return $chargeUrl . self::URL_SEPARATOR . $chargeId . self::URL_SEPARATOR . self::RAKUTENPAY_REFUND_PARTIAL;
    }

    /**
     * @param string $environment
     * @return string
     */
    public static function createCalculationUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::RAKUTENLOG_CALCULATION : $environment;
    }

    /**
     * @param string $environment
     * @param bool $online
     * @return string
     */
    public static function buildAutocompleteUrl($environment, $online)
    {
        if (true === $online) {

            return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::RAKUTENLOG_AUTOCOMPLETE_ONLINE : $environment;
        }

        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::RAKUTENLOG_AUTOCOMPLETE : $environment;
    }

    /**
     * @param string $environment
     * @return string
     */
    public static function generateBatchUrl($environment)
    {
        return isset(self::$environment[$environment]) ? self::$environment[$environment] . self::RAKUTENLOG_BATCH : $environment;
    }
}