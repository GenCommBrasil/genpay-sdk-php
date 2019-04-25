<?php

namespace Rakuten\Connector\Service\Http;

use Rakuten\Connector\Exception\RakutenException;

/**
 * Interface Method
 * @package Rakuten\Connector\Service\Http
 */
interface Method
{
    /**
     * @param $url
     * @param string $data
     * @param int $timeout
     * @param string $charset
     * @return bool
     * @throws RakutenException
     */
    public function post($url, $data = '', $timeout = 20, $charset = 'ISO-8859-1');

    /**
     * @param $url
     * @param int $timeout
     * @param string $charset
     * @param bool $secureGet
     * @return bool
     * @throws RakutenException
     */
    public function get($url, $timeout = 20, $charset = 'ISO-8859-1', $secureGet = true);
}
