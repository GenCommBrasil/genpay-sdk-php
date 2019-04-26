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
